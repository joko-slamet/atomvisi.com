<?php

namespace App\Services;

use App\Models\PoliticalCalculatorSetting;
use App\Models\PoliticalCalculatorSubmission;
use App\Support\PoliticalCalculatorOptions;

class PoliticalCalculatorAnalyzer
{
    public function __construct(protected OpenRouterService $openRouter) {}

    /**
     * @param  array{age_range: string, candidate_status: string, public_recognition: string, voter_target: string, main_goal: string, local_issues: array<int, string>, about_you: ?string}  $profile
     */
    public function generate(string $province, string $city, string $target, ?string $ip = null, array $profile = []): PoliticalCalculatorSubmission
    {
        $settings = PoliticalCalculatorSetting::current();

        $profileLabels = [
            'age_range_label' => PoliticalCalculatorOptions::ageRanges()[$profile['age_range'] ?? ''] ?? null,
            'candidate_status_label' => PoliticalCalculatorOptions::candidateStatuses()[$profile['candidate_status'] ?? ''] ?? null,
            'public_recognition_label' => PoliticalCalculatorOptions::recognitionLevels()[$profile['public_recognition'] ?? ''] ?? null,
            'voter_target_label' => PoliticalCalculatorOptions::voterTargets()[$profile['voter_target'] ?? ''] ?? null,
            'main_goal_label' => PoliticalCalculatorOptions::mainGoals()[$profile['main_goal'] ?? ''] ?? null,
            'local_issues_labels' => collect($profile['local_issues'] ?? [])
                ->map(fn ($key) => PoliticalCalculatorOptions::localIssues()[$key] ?? $key)
                ->all(),
            'about_you' => $profile['about_you'] ?? null,
        ];

        $generated = $this->openRouter->generatePoliticalAnalysis($province, $city, $target, $settings->model, $profileLabels);

        return PoliticalCalculatorSubmission::create([
            'provinsi' => $province,
            'kota' => $city !== '' ? $city : null,
            'target_jabatan' => $target,
            'age_range' => $profile['age_range'] ?? null,
            'candidate_status' => $profile['candidate_status'] ?? null,
            'public_recognition' => $profile['public_recognition'] ?? null,
            'voter_target' => $profile['voter_target'] ?? null,
            'main_goal' => $profile['main_goal'] ?? null,
            'local_issues' => $profile['local_issues'] ?? [],
            'about_you' => $profile['about_you'] ?? null,
            ...$generated,
            'ai_model' => $settings->resolvedModel(),
            'ip_address' => $ip,
        ]);
    }
}
