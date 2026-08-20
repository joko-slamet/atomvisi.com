<?php

namespace App\Models;

use App\Support\PoliticalCalculatorOptions;
use Illuminate\Database\Eloquent\Model;

class PoliticalCalculatorSubmission extends Model
{
    protected $fillable = [
        'provinsi',
        'kota',
        'target_jabatan',
        'age_range',
        'candidate_status',
        'public_recognition',
        'voter_target',
        'main_goal',
        'local_issues',
        'about_you',
        'jumlah_penduduk',
        'jumlah_pemilih_potensial',
        'kelompok_umur_dominan',
        'langkah_strategis',
        'porsi_komunikasi',
        'roadmap',
        'ai_model',
        'ip_address',
        'is_read',
    ];

    protected $casts = [
        'jumlah_penduduk' => 'integer',
        'jumlah_pemilih_potensial' => 'integer',
        'local_issues' => 'array',
        'langkah_strategis' => 'array',
        'porsi_komunikasi' => 'array',
        'roadmap' => 'array',
        'is_read' => 'boolean',
    ];

    public function getTargetJabatanLabelAttribute(): string
    {
        return match ($this->target_jabatan) {
            'gubernur' => 'Gubernur',
            'walikota' => 'Walikota',
            'bupati' => 'Bupati',
            'caleg' => 'Calon Legislatif (Caleg)',
            default => $this->target_jabatan,
        };
    }

    public function getRegionLabelAttribute(): string
    {
        return $this->kota ? "{$this->kota}, {$this->provinsi}" : $this->provinsi;
    }

    public function getAgeRangeLabelAttribute(): ?string
    {
        return PoliticalCalculatorOptions::ageRanges()[$this->age_range] ?? $this->age_range;
    }

    public function getCandidateStatusLabelAttribute(): ?string
    {
        return PoliticalCalculatorOptions::candidateStatuses()[$this->candidate_status] ?? $this->candidate_status;
    }

    public function getPublicRecognitionLabelAttribute(): ?string
    {
        return PoliticalCalculatorOptions::recognitionLevels()[$this->public_recognition] ?? $this->public_recognition;
    }

    public function getVoterTargetLabelAttribute(): ?string
    {
        return PoliticalCalculatorOptions::voterTargets()[$this->voter_target] ?? $this->voter_target;
    }

    public function getMainGoalLabelAttribute(): ?string
    {
        return PoliticalCalculatorOptions::mainGoals()[$this->main_goal] ?? $this->main_goal;
    }

    /**
     * @return array<int, string>
     */
    public function getLocalIssuesLabelsAttribute(): array
    {
        $issues = PoliticalCalculatorOptions::localIssues();

        return collect($this->local_issues ?? [])
            ->map(fn ($key) => $issues[$key] ?? $key)
            ->all();
    }
}
