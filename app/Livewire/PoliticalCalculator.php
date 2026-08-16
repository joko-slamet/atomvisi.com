<?php

namespace App\Livewire;

use App\Models\PoliticalCalculatorSetting;
use App\Models\PoliticalCalculatorSubmission;
use App\Services\PoliticalCalculatorAnalyzer;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class PoliticalCalculator extends Component
{
    #[Validate('required|in:gubernur,walikota,bupati,caleg')]
    public string $target_jabatan = '';

    #[Validate('required|string|max:100')]
    public string $provinsi = '';

    #[Validate('required_unless:target_jabatan,gubernur|string|max:100')]
    public string $kota = '';

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
            $this->kota = '';
        }
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

        try {
            $this->result = $analyzer->generate(
                $this->provinsi,
                $this->kota,
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
        $this->reset(['target_jabatan', 'provinsi', 'kota', 'website', 'submitted', 'result', 'errorMessage']);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.political-calculator');
    }
}
