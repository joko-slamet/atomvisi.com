<?php

namespace App\Services;

use App\Models\PoliticalCalculatorSetting;
use App\Models\PoliticalCalculatorSubmission;

class PoliticalCalculatorAnalyzer
{
    public function __construct(protected OpenRouterService $openRouter) {}

    public function generate(string $province, string $city, string $target, ?string $ip = null): PoliticalCalculatorSubmission
    {
        $settings = PoliticalCalculatorSetting::current();

        $generated = $this->openRouter->generatePoliticalAnalysis($province, $city, $target, $settings->model);

        return PoliticalCalculatorSubmission::create([
            'provinsi' => $province,
            'kota' => $city !== '' ? $city : null,
            'target_jabatan' => $target,
            ...$generated,
            'ai_model' => $settings->resolvedModel(),
            'ip_address' => $ip,
        ]);
    }
}
