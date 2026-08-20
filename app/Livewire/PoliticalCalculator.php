<?php

namespace App\Livewire;

use App\Models\PoliticalCalculatorSetting;
use App\Models\PoliticalCalculatorSubmission;
use App\Services\PoliticalCalculatorAnalyzer;
use App\Support\PoliticalCalculatorOptions;
use App\Support\WilayahIndonesia;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Throwable;

class PoliticalCalculator extends Component
{
    public string $target_jabatan = '';

    public string $provinsi_id = '';

    public string $kota_id = '';

    public string $age_range = '';

    public string $candidate_status = '';

    public string $public_recognition = '';

    public string $voter_target = '';

    public string $main_goal = '';

    /** @var array<int, string> */
    public array $local_issues = [];

    public string $about_you = '';

    // Honeypot: hidden from real visitors via CSS, bots tend to fill every field.
    public string $website = '';

    // Time-trap: rejects submissions faster than a human could plausibly fill the form.
    public ?int $renderedAt = null;

    public bool $submitted = false;

    public ?PoliticalCalculatorSubmission $result = null;

    public ?string $errorMessage = null;

    public function mount(): void
    {
        $this->renderedAt = now()->timestamp;
    }

    public function updatedTargetJabatan(): void
    {
        if ($this->target_jabatan === 'gubernur') {
            $this->kota_id = '';
        }
    }

    public function updatedProvinsiId(): void
    {
        $this->kota_id = '';
    }

    public function getProvincesProperty(): array
    {
        return WilayahIndonesia::provinces();
    }

    public function getRegenciesProperty(): array
    {
        return WilayahIndonesia::regencies($this->provinsi_id);
    }

    protected function rules(): array
    {
        $rules = [
            'target_jabatan' => ['required', Rule::in(['gubernur', 'walikota', 'bupati', 'caleg'])],
            'provinsi_id' => ['required', Rule::in(array_keys(WilayahIndonesia::provinces()))],
            'age_range' => ['required', Rule::in(array_keys(PoliticalCalculatorOptions::ageRanges()))],
            'candidate_status' => ['required', Rule::in(array_keys(PoliticalCalculatorOptions::candidateStatuses()))],
            'public_recognition' => ['required', Rule::in(array_keys(PoliticalCalculatorOptions::recognitionLevels()))],
            'voter_target' => ['required', Rule::in(array_keys(PoliticalCalculatorOptions::voterTargets()))],
            'main_goal' => ['required', Rule::in(array_keys(PoliticalCalculatorOptions::mainGoals()))],
            'local_issues' => ['required', 'array', 'min:1', 'max:3'],
            'local_issues.*' => [Rule::in(array_keys(PoliticalCalculatorOptions::localIssues()))],
            'about_you' => ['nullable', 'string', 'max:1000'],
        ];

        if ($this->target_jabatan !== 'gubernur') {
            $rules['kota_id'] = ['required', Rule::in(array_keys(WilayahIndonesia::regencies($this->provinsi_id)))];
        }

        return $rules;
    }

    public function submit(PoliticalCalculatorAnalyzer $analyzer): void
    {
        $this->validate();
        $this->errorMessage = null;

        if (filled($this->website)) {
            // Silently "succeed" for bots without spending an AI call.
            $this->submitted = true;

            return;
        }

        if ($this->renderedAt && now()->timestamp - $this->renderedAt < 3) {
            $this->errorMessage = __('Formulir dikirim terlalu cepat. Silakan coba lagi.');

            return;
        }

        $settings = PoliticalCalculatorSetting::current();

        if (! $settings->is_enabled) {
            $this->errorMessage = __('Kalkulator Politik sedang tidak tersedia. Silakan coba lagi nanti.');

            return;
        }

        $ip = request()->ip();
        $hourKey = "political-calculator:hour:{$ip}";
        $dayKey = "political-calculator:day:{$ip}";

        if (RateLimiter::tooManyAttempts($hourKey, 3) || RateLimiter::tooManyAttempts($dayKey, $settings->max_submissions_per_ip_per_day)) {
            $this->errorMessage = __('Anda telah mencapai batas maksimal percobaan. Silakan coba lagi nanti.');

            return;
        }

        RateLimiter::hit($hourKey, 900);
        RateLimiter::hit($dayKey, 86400);

        $province = WilayahIndonesia::provinceName($this->provinsi_id);
        $city = $this->kota_id ? WilayahIndonesia::regencyName($this->provinsi_id, $this->kota_id) : '';

        try {
            $this->result = $analyzer->generate(
                $province,
                $city,
                $this->target_jabatan,
                $ip,
                [
                    'age_range' => $this->age_range,
                    'candidate_status' => $this->candidate_status,
                    'public_recognition' => $this->public_recognition,
                    'voter_target' => $this->voter_target,
                    'main_goal' => $this->main_goal,
                    'local_issues' => $this->local_issues,
                    'about_you' => $this->about_you !== '' ? $this->about_you : null,
                ],
            );
            $this->submitted = true;

            // Hasil ditampilkan & disimpan sebagai riwayat di localStorage sisi klien
            // (lihat politicalCalculatorResult di resources/js/app.js), terpisah dari
            // record di database yang tetap tersimpan untuk keperluan admin.
            $this->dispatch('calculator-result-ready', payload: $this->resultPayload());
        } catch (Throwable $e) {
            report($e);
            $this->errorMessage = __('Gagal memproses estimasi. Silakan coba lagi dalam beberapa saat.');
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function resultPayload(): array
    {
        return [
            'region_label' => $this->result->region_label,
            'target_jabatan_label' => $this->result->target_jabatan_label,
            'ringkasan_analisis' => $this->result->ringkasan_analisis,
            'jumlah_penduduk' => $this->result->jumlah_penduduk,
            'jumlah_pemilih_potensial' => $this->result->jumlah_pemilih_potensial,
            'kelompok_umur_dominan' => $this->result->kelompok_umur_dominan,
            'pesan_utama' => $this->result->pesan_utama,
            'langkah_strategis' => $this->result->langkah_strategis,
            'porsi_komunikasi' => $this->result->porsi_komunikasi,
            'fokus_isu' => $this->result->fokus_isu,
            'roadmap' => $this->result->roadmap,
        ];
    }

    public function resetForm(): void
    {
        $this->reset([
            'target_jabatan', 'provinsi_id', 'kota_id',
            'age_range', 'candidate_status', 'public_recognition', 'voter_target', 'main_goal', 'local_issues', 'about_you',
            'website', 'submitted', 'result', 'errorMessage',
        ]);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.political-calculator');
    }
}
