<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\PageStat;
use App\Models\ResearchProject;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@atomvisi.com'],
            ['name' => 'Admin Atom Visi', 'password' => bcrypt('password')]
        );

        $this->seedCategories();
        $this->seedServices();
        $this->seedTeam();
        $this->seedTestimonials();
        $this->seedStats();
        $this->seedArticles();
        $this->seedResearch();
    }

    private function seedCategories(): void
    {
        foreach (['Kebijakan Publik', 'Politik & Geopolitik', 'Sosial', 'Ekonomi'] as $name) {
            Category::firstOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'type' => 'article',
            ]);
        }

        foreach (['Kebijakan Publik', 'Geopolitik', 'Survey Sosial'] as $name) {
            Category::firstOrCreate(['slug' => Str::slug($name).'-riset'], [
                'name' => $name,
                'slug' => Str::slug($name).'-riset',
                'type' => 'research',
            ]);
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'name' => 'Policy & Government Performance',
                'icon' => 'heroicon-o-scale',
                'short_description' => 'Analisis kebijakan dan evaluasi kinerja pemerintahan berbasis data dan bukti.',
                'description' => '<p>Kami melakukan analisis kebijakan dan evaluasi kinerja pemerintahan untuk membantu pemerintah, lembaga, dan organisasi memahami dampak kebijakan serta merumuskan solusi berbasis bukti.</p>',
            ],
            [
                'name' => 'Survey & Data Analyses',
                'icon' => 'heroicon-o-chart-bar',
                'short_description' => 'Survey opini publik dan analisis data dengan metodologi yang terukur.',
                'description' => '<p>Kami merancang dan melaksanakan survey serta analisis data berskala nasional maupun regional dengan metodologi ilmiah yang dapat dipertanggungjawabkan.</p>',
            ],
            [
                'name' => 'Strategy Private Class',
                'icon' => 'heroicon-o-light-bulb',
                'short_description' => 'Kelas privat strategi dan konsultasi intensif bagi pemangku kepentingan.',
                'description' => '<p>Kami menyelenggarakan kelas privat strategi yang menerjemahkan hasil riset menjadi rekomendasi dan kapasitas strategis yang aplikatif bagi pemangku kepentingan.</p>',
            ],
            [
                'name' => 'Media Handling',
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'short_description' => 'Pengelolaan komunikasi dan media untuk mendukung narasi strategis klien.',
                'description' => '<p>Kami membantu pengelolaan komunikasi dan media, termasuk penyusunan narasi strategis dan respons publik bagi klien institusi.</p>',
            ],
            [
                'name' => 'Event & Workshop',
                'icon' => 'heroicon-o-calendar-days',
                'short_description' => 'Diskusi publik, seminar, dan workshop untuk memperkaya wacana kebijakan.',
                'description' => '<p>Kami menyelenggarakan diskusi publik, seminar, dan workshop yang mempertemukan akademisi, praktisi, dan pengambil kebijakan.</p>',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::firstOrCreate(['slug' => Str::slug($service['name'])], [
                ...$service,
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedTeam(): void
    {
        $team = [
            ['name' => 'Dr. Arya Wicaksono', 'role' => 'Founder & Direktur Eksekutif'],
            ['name' => 'Nadia Puspita, M.Si.', 'role' => 'Kepala Riset Kebijakan Publik'],
            ['name' => 'Bima Satria, M.A.', 'role' => 'Analis Politik & Geopolitik Senior'],
            ['name' => 'Clara Amelia, M.Si.', 'role' => 'Kepala Divisi Survey & Kajian Sosial'],
            ['name' => 'Raka Pratama', 'role' => 'Manajer Program & Kemitraan'],
            ['name' => 'Sarah Indraswari, M.Sc.', 'role' => 'Peneliti Ekonomi Kebijakan'],
        ];

        foreach ($team as $index => $member) {
            TeamMember::firstOrCreate(['slug' => Str::slug($member['name'])], [
                ...$member,
                'bio' => 'Peneliti berpengalaman dengan fokus pada isu-isu kebijakan publik dan strategi pembangunan di Indonesia.',
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'client_name' => 'Farhan Nugraha',
                'client_role' => 'Kepala Bagian Perencanaan',
                'client_company' => 'Kementerian/Lembaga Pemerintah',
                'quote' => 'Riset yang disusun Atom Visi Indonesia sangat tajam dan aplikatif, membantu kami merumuskan kebijakan yang lebih tepat sasaran.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Dewi Anggraini',
                'client_role' => 'Direktur Program',
                'client_company' => 'Yayasan Kebijakan Nusantara',
                'quote' => 'Tim yang profesional dengan metodologi survey yang kredibel. Hasil kajian mereka menjadi rujukan utama kami.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Hendra Wijaya',
                'client_role' => 'Corporate Affairs Manager',
                'client_company' => 'Perusahaan Multinasional',
                'quote' => 'Analisis geopolitik dari Atom Visi Indonesia memberikan kami gambaran risiko dan peluang yang komprehensif.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::firstOrCreate(['client_name' => $testimonial['client_name']], [
                ...$testimonial,
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedStats(): void
    {
        $stats = [
            ['label' => 'Riset Selesai', 'value' => 120, 'suffix' => '+', 'icon' => 'heroicon-o-magnifying-glass'],
            ['label' => 'Klien & Mitra Institusi', 'value' => 45, 'suffix' => '+', 'icon' => 'heroicon-o-users'],
            ['label' => 'Tahun Pengalaman', 'value' => 10, 'suffix' => '+', 'icon' => 'heroicon-o-calendar-days'],
            ['label' => 'Peneliti Ahli', 'value' => 25, 'suffix' => '+', 'icon' => 'heroicon-o-light-bulb'],
        ];

        foreach ($stats as $index => $stat) {
            PageStat::firstOrCreate(['label' => $stat['label']], [
                ...$stat,
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedArticles(): void
    {
        $categoryIds = Category::where('type', 'article')->pluck('id');
        $authorIds = TeamMember::pluck('id');

        $articles = [
            ['type' => 'article', 'title' => 'Tren Kebijakan Publik Indonesia di Tahun Politik'],
            ['type' => 'article', 'title' => 'Membaca Arah Kebijakan Ekonomi Pasca Pemilu'],
            ['type' => 'article', 'title' => 'Digitalisasi Layanan Publik: Peluang dan Tantangan'],
            ['type' => 'op-ed', 'title' => 'Mengapa Diplomasi Ekonomi Perlu Diperkuat'],
            ['type' => 'op-ed', 'title' => 'Polarisasi Politik dan Ancaman terhadap Kohesi Sosial'],
            ['type' => 'newsletter', 'title' => 'Ringkasan Kajian Triwulan I 2026'],
            ['type' => 'newsletter', 'title' => 'Update Riset: Persepsi Publik terhadap Kebijakan Energi'],
        ];

        foreach ($articles as $index => $article) {
            Article::firstOrCreate(['slug' => Str::slug($article['title'])], [
                ...$article,
                'slug' => Str::slug($article['title']),
                'category_id' => $categoryIds->random(),
                'author_id' => $authorIds->random(),
                'excerpt' => 'Kajian ini membahas perkembangan terkini serta implikasi strategisnya bagi pemangku kepentingan di Indonesia.',
                'content' => '<p>Kajian ini membahas perkembangan terkini serta implikasi strategisnya bagi pemangku kepentingan di Indonesia. Atom Visi Indonesia menyusun analisis ini berdasarkan data primer dan sekunder yang relevan.</p><p>Rekomendasi strategis disusun untuk membantu pengambil kebijakan merespons dinamika yang berkembang secara tepat dan terukur.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(($index + 1) * 4),
                'views' => rand(50, 800),
            ]);
        }
    }

    private function seedResearch(): void
    {
        $categoryIds = Category::where('type', 'research')->pluck('id');

        $projects = [
            ['title' => 'Kajian Efektivitas Program Bantuan Sosial Nasional', 'is_featured' => true],
            ['title' => 'Pemetaan Risiko Geopolitik Kawasan Indo-Pasifik', 'is_featured' => true],
            ['title' => 'Survey Persepsi Publik terhadap Reformasi Birokrasi', 'is_featured' => true],
            ['title' => 'Analisis Dampak Kebijakan Subsidi Energi', 'is_featured' => false],
            ['title' => 'Studi Kohesi Sosial di Wilayah Perkotaan', 'is_featured' => false],
        ];

        foreach ($projects as $index => $project) {
            ResearchProject::firstOrCreate(['slug' => Str::slug($project['title'])], [
                ...$project,
                'slug' => Str::slug($project['title']),
                'category_id' => $categoryIds->random(),
                'client' => 'Kementerian/Lembaga & Mitra Pembangunan',
                'year' => now()->year - rand(0, 2),
                'summary' => 'Kajian komprehensif yang menghasilkan rekomendasi strategis bagi pemangku kepentingan terkait.',
                'content' => '<p>Kajian ini dilaksanakan menggunakan metodologi campuran (mixed-methods) yang menggabungkan analisis data kuantitatif dan kualitatif untuk menghasilkan temuan yang komprehensif dan rekomendasi yang aplikatif.</p>',
                'status' => 'published',
                'order' => $index,
            ]);
        }
    }
}
