<?php

namespace App\Livewire;

use App\Models\PoliticalCalculatorSetting;
use App\Models\PoliticalCalculatorSubmission;
use App\Services\PoliticalCalculatorAnalyzer;
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
            );
            $this->submitted = true;
        } catch (Throwable $e) {
            report($e);
            $this->errorMessage = __('Gagal memproses estimasi. Silakan coba lagi dalam beberapa saat.');
        }
    }

    public function resetForm(): void
    {
        $this->reset(['target_jabatan', 'provinsi_id', 'kota_id', 'website', 'submitted', 'result', 'errorMessage']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.political-calculator');
    }
}
