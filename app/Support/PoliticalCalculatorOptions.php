<?php

namespace App\Support;

class PoliticalCalculatorOptions
{
    /**
     * @return array<string, string>
     */
    public static function ageRanges(): array
    {
        return [
            'under_30' => 'Di bawah 30 tahun',
            '30_39' => '30 - 39 tahun',
            '40_49' => '40 - 49 tahun',
            '50_59' => '50 - 59 tahun',
            '60_plus' => 'Di atas 60 tahun',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function candidateStatuses(): array
    {
        return [
            'first_time' => 'Pertama Kali Mencalonkan',
            'previously_ran' => 'Pernah Mencalonkan',
            'incumbent' => 'Petahana',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function recognitionLevels(): array
    {
        return [
            'low' => 'Belum Banyak Dikenal',
            'moderate' => 'Cukup Dikenal',
            'well_known' => 'Dikenal Luas',
            'very_strong' => 'Sangat Dikenal',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function voterTargets(): array
    {
        return [
            'youth' => 'Anak Muda',
            'women' => 'Perempuan',
            'families' => 'Keluarga',
            'msmes' => 'Pelaku UMKM',
            'farmers' => 'Petani',
            'workers' => 'Pekerja',
            'professionals' => 'Profesional',
            'religious_communities' => 'Komunitas Keagamaan',
            'others' => 'Lainnya',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function mainGoals(): array
    {
        return [
            'build_awareness' => 'Meningkatkan Pengenalan',
            'introduce_myself' => 'Memperkenalkan Profil & Program',
            'build_support_network' => 'Membangun Jaringan Dukungan',
            'increase_electability' => 'Meningkatkan Elektabilitas',
            'mobilize_supporters' => 'Menggerakkan Pendukung',
            'full_campaign_strategy' => 'Menyusun Strategi Kampanye',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function localIssues(): array
    {
        return [
            'economy_cost_of_living' => 'Ekonomi & Biaya Hidup',
            'jobs_employment' => 'Lapangan Kerja',
            'msmes_local_business' => 'UMKM & Usaha Lokal',
            'education' => 'Pendidikan',
            'healthcare' => 'Kesehatan',
            'infrastructure_transportation' => 'Infrastruktur & Transportasi',
            'agriculture_food_security' => 'Pertanian & Pangan',
            'environment_flooding' => 'Lingkungan & Banjir',
            'public_services_welfare' => 'Pelayanan Publik & Kesejahteraan',
            'public_safety_security' => 'Keamanan & Ketertiban',
        ];
    }
}
