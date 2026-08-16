<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoliticalCalculatorSubmission extends Model
{
    protected $fillable = [
        'provinsi',
        'kota',
        'target_jabatan',
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
}
