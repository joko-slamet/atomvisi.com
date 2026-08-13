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
            ['email' => env('ADMIN_EMAIL', 'admin@atomvisi.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin Atom Visi'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            ]
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
        $articleCategories = [
            ['id' => 'Kebijakan Publik', 'en' => 'Public Policy'],
            ['id' => 'Politik & Geopolitik', 'en' => 'Politics & Geopolitics'],
            ['id' => 'Sosial', 'en' => 'Social'],
            ['id' => 'Ekonomi', 'en' => 'Economy'],
        ];

        foreach ($articleCategories as $name) {
            Category::updateOrCreate(['slug' => Str::slug($name['id'])], [
                'name' => $name,
                'type' => 'article',
            ]);
        }

        $researchCategories = [
            ['id' => 'Kebijakan Publik', 'en' => 'Public Policy'],
            ['id' => 'Geopolitik', 'en' => 'Geopolitics'],
            ['id' => 'Survey Sosial', 'en' => 'Social Survey'],
        ];

        foreach ($researchCategories as $name) {
            Category::updateOrCreate(['slug' => Str::slug($name['id']).'-riset'], [
                'name' => $name,
                'slug' => Str::slug($name['id']).'-riset',
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
                'short_description' => [
                    'id' => 'Analisis kebijakan dan evaluasi kinerja pemerintahan berbasis data dan bukti.',
                    'en' => 'Policy analysis and government performance evaluation grounded in data and evidence.',
                ],
                'description' => [
                    'id' => '<p>Kami melakukan analisis kebijakan dan evaluasi kinerja pemerintahan untuk membantu pemerintah, lembaga, dan organisasi memahami dampak kebijakan serta merumuskan solusi berbasis bukti.</p>',
                    'en' => '<p>We conduct policy analysis and government performance evaluations to help governments, institutions, and organizations understand policy impact and develop evidence-based solutions.</p>',
                ],
            ],
            [
                'name' => 'Survey & Data Analyses',
                'icon' => 'heroicon-o-chart-bar',
                'short_description' => [
                    'id' => 'Survey opini publik dan analisis data dengan metodologi yang terukur.',
                    'en' => 'Public opinion surveys and data analysis using rigorous, measurable methodology.',
                ],
                'description' => [
                    'id' => '<p>Kami merancang dan melaksanakan survey serta analisis data berskala nasional maupun regional dengan metodologi ilmiah yang dapat dipertanggungjawabkan.</p>',
                    'en' => '<p>We design and conduct national and regional-scale surveys and data analysis using scientifically accountable methodology.</p>',
                ],
            ],
            [
                'name' => 'Strategy Private Class',
                'icon' => 'heroicon-o-light-bulb',
                'short_description' => [
                    'id' => 'Kelas privat strategi dan konsultasi intensif bagi pemangku kepentingan.',
                    'en' => 'Private strategy classes and intensive consulting for stakeholders.',
                ],
                'description' => [
                    'id' => '<p>Kami menyelenggarakan kelas privat strategi yang menerjemahkan hasil riset menjadi rekomendasi dan kapasitas strategis yang aplikatif bagi pemangku kepentingan.</p>',
                    'en' => '<p>We deliver private strategy classes that translate research findings into actionable recommendations and strategic capacity for stakeholders.</p>',
                ],
            ],
            [
                'name' => 'Media Handling',
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'short_description' => [
                    'id' => 'Pengelolaan komunikasi dan media untuk mendukung narasi strategis klien.',
                    'en' => "Communication and media management to support clients' strategic narratives.",
                ],
                'description' => [
                    'id' => '<p>Kami membantu pengelolaan komunikasi dan media, termasuk penyusunan narasi strategis dan respons publik bagi klien institusi.</p>',
                    'en' => '<p>We assist with communication and media management, including strategic narrative development and public response for institutional clients.</p>',
                ],
            ],
            [
                'name' => 'Event & Workshop',
                'icon' => 'heroicon-o-calendar-days',
                'short_description' => [
                    'id' => 'Diskusi publik, seminar, dan workshop untuk memperkaya wacana kebijakan.',
                    'en' => 'Public discussions, seminars, and workshops to enrich policy discourse.',
                ],
                'description' => [
                    'id' => '<p>Kami menyelenggarakan diskusi publik, seminar, dan workshop yang mempertemukan akademisi, praktisi, dan pengambil kebijakan.</p>',
                    'en' => '<p>We organize public discussions, seminars, and workshops that bring together academics, practitioners, and policymakers.</p>',
                ],
            ],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(['slug' => Str::slug($service['name'])], [
                ...$service,
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedTeam(): void
    {
        $bio = [
            'id' => 'Peneliti berpengalaman dengan fokus pada isu-isu kebijakan publik dan strategi pembangunan di Indonesia.',
            'en' => 'An experienced researcher focused on public policy issues and development strategy in Indonesia.',
        ];

        $team = [
            [
                'name' => 'Dr. Arya Wicaksono',
                'role' => ['id' => 'Founder & Direktur Eksekutif', 'en' => 'Founder & Executive Director'],
            ],
            [
                'name' => 'Nadia Puspita, M.Si.',
                'role' => ['id' => 'Kepala Riset Kebijakan Publik', 'en' => 'Head of Public Policy Research'],
            ],
            [
                'name' => 'Bima Satria, M.A.',
                'role' => ['id' => 'Analis Politik & Geopolitik Senior', 'en' => 'Senior Political & Geopolitical Analyst'],
            ],
            [
                'name' => 'Clara Amelia, M.Si.',
                'role' => ['id' => 'Kepala Divisi Survey & Kajian Sosial', 'en' => 'Head of Survey & Social Studies Division'],
            ],
            [
                'name' => 'Raka Pratama',
                'role' => ['id' => 'Manajer Program & Kemitraan', 'en' => 'Program & Partnerships Manager'],
            ],
            [
                'name' => 'Sarah Indraswari, M.Sc.',
                'role' => ['id' => 'Peneliti Ekonomi Kebijakan', 'en' => 'Policy Economics Researcher'],
            ],
        ];

        foreach ($team as $index => $member) {
            TeamMember::updateOrCreate(['slug' => Str::slug($member['name'])], [
                ...$member,
                'bio' => $bio,
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
                'client_role' => ['id' => 'Kepala Bagian Perencanaan', 'en' => 'Head of Planning Division'],
                'client_company' => ['id' => 'Kementerian/Lembaga Pemerintah', 'en' => 'Ministry/Government Institution'],
                'quote' => [
                    'id' => 'Riset yang disusun Atom Visi Indonesia sangat tajam dan aplikatif, membantu kami merumuskan kebijakan yang lebih tepat sasaran.',
                    'en' => 'The research produced by Atom Visi Indonesia is sharp and actionable, helping us formulate more targeted policies.',
                ],
                'rating' => 5,
            ],
            [
                'client_name' => 'Dewi Anggraini',
                'client_role' => ['id' => 'Direktur Program', 'en' => 'Program Director'],
                'client_company' => ['id' => 'Yayasan Kebijakan Nusantara', 'en' => 'Nusantara Policy Foundation'],
                'quote' => [
                    'id' => 'Tim yang profesional dengan metodologi survey yang kredibel. Hasil kajian mereka menjadi rujukan utama kami.',
                    'en' => 'A professional team with credible survey methodology. Their research results have become our primary reference.',
                ],
                'rating' => 5,
            ],
            [
                'client_name' => 'Hendra Wijaya',
                'client_role' => ['id' => 'Corporate Affairs Manager', 'en' => 'Corporate Affairs Manager'],
                'client_company' => ['id' => 'Perusahaan Multinasional', 'en' => 'Multinational Corporation'],
                'quote' => [
                    'id' => 'Analisis geopolitik dari Atom Visi Indonesia memberikan kami gambaran risiko dan peluang yang komprehensif.',
                    'en' => "Atom Visi Indonesia's geopolitical analysis gave us a comprehensive picture of risks and opportunities.",
                ],
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::updateOrCreate(['client_name' => $testimonial['client_name']], [
                ...$testimonial,
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedStats(): void
    {
        $stats = [
            ['label' => ['id' => 'Riset Selesai', 'en' => 'Research Completed'], 'value' => 120, 'suffix' => '+', 'icon' => 'heroicon-o-magnifying-glass'],
            ['label' => ['id' => 'Klien & Mitra Institusi', 'en' => 'Clients & Institutional Partners'], 'value' => 45, 'suffix' => '+', 'icon' => 'heroicon-o-users'],
            ['label' => ['id' => 'Tahun Pengalaman', 'en' => 'Years of Experience'], 'value' => 10, 'suffix' => '+', 'icon' => 'heroicon-o-calendar-days'],
            ['label' => ['id' => 'Peneliti Ahli', 'en' => 'Expert Researchers'], 'value' => 25, 'suffix' => '+', 'icon' => 'heroicon-o-light-bulb'],
        ];

        foreach ($stats as $index => $stat) {
            PageStat::updateOrCreate(['order' => $index], [
                ...$stat,
                'is_active' => true,
            ]);
        }
    }

    private function seedArticles(): void
    {
        $categoryIds = Category::where('type', 'article')->pluck('id');
        $authorIds = TeamMember::pluck('id');

        $excerpt = [
            'id' => 'Kajian ini membahas perkembangan terkini serta implikasi strategisnya bagi pemangku kepentingan di Indonesia.',
            'en' => 'This study examines recent developments and their strategic implications for stakeholders in Indonesia.',
        ];

        $content = [
            'id' => '<p>Kajian ini membahas perkembangan terkini serta implikasi strategisnya bagi pemangku kepentingan di Indonesia. Atom Visi Indonesia menyusun analisis ini berdasarkan data primer dan sekunder yang relevan.</p><p>Rekomendasi strategis disusun untuk membantu pengambil kebijakan merespons dinamika yang berkembang secara tepat dan terukur.</p>',
            'en' => '<p>This study examines recent developments and their strategic implications for stakeholders in Indonesia. Atom Visi Indonesia developed this analysis based on relevant primary and secondary data.</p><p>Strategic recommendations were formulated to help policymakers respond to evolving dynamics accurately and effectively.</p>',
        ];

        $articles = [
            ['type' => 'article', 'title' => ['id' => 'Tren Kebijakan Publik Indonesia di Tahun Politik', 'en' => "Indonesia's Public Policy Trends in an Election Year"]],
            ['type' => 'article', 'title' => ['id' => 'Membaca Arah Kebijakan Ekonomi Pasca Pemilu', 'en' => 'Reading the Direction of Economic Policy After the Election']],
            ['type' => 'article', 'title' => ['id' => 'Digitalisasi Layanan Publik: Peluang dan Tantangan', 'en' => 'Digitalization of Public Services: Opportunities and Challenges']],
            ['type' => 'op-ed', 'title' => ['id' => 'Mengapa Diplomasi Ekonomi Perlu Diperkuat', 'en' => 'Why Economic Diplomacy Needs to Be Strengthened']],
            ['type' => 'op-ed', 'title' => ['id' => 'Polarisasi Politik dan Ancaman terhadap Kohesi Sosial', 'en' => 'Political Polarization and the Threat to Social Cohesion']],
            ['type' => 'newsletter', 'title' => ['id' => 'Ringkasan Kajian Triwulan I 2026', 'en' => 'Q1 2026 Research Summary']],
            ['type' => 'newsletter', 'title' => ['id' => 'Update Riset: Persepsi Publik terhadap Kebijakan Energi', 'en' => 'Research Update: Public Perception of Energy Policy']],
        ];

        foreach ($articles as $index => $article) {
            $slug = Str::slug($article['title']['id']);

            Article::updateOrCreate(['slug' => $slug], [
                ...$article,
                'slug' => $slug,
                'category_id' => $categoryIds->random(),
                'author_id' => $authorIds->random(),
                'excerpt' => $excerpt,
                'content' => $content,
                'status' => 'published',
                'published_at' => now()->subDays(($index + 1) * 4),
                'views' => rand(50, 800),
            ]);
        }
    }

    private function seedResearch(): void
    {
        $categoryIds = Category::where('type', 'research')->pluck('id');

        $summary = [
            'id' => 'Kajian komprehensif yang menghasilkan rekomendasi strategis bagi pemangku kepentingan terkait.',
            'en' => 'A comprehensive study that produces strategic recommendations for relevant stakeholders.',
        ];

        $content = [
            'id' => '<p>Kajian ini dilaksanakan menggunakan metodologi campuran (mixed-methods) yang menggabungkan analisis data kuantitatif dan kualitatif untuk menghasilkan temuan yang komprehensif dan rekomendasi yang aplikatif.</p>',
            'en' => '<p>This study was conducted using a mixed-methods approach that combines quantitative and qualitative data analysis to produce comprehensive findings and actionable recommendations.</p>',
        ];

        $projects = [
            ['title' => ['id' => 'Kajian Efektivitas Program Bantuan Sosial Nasional', 'en' => 'Effectiveness Study of the National Social Assistance Program'], 'is_featured' => true],
            ['title' => ['id' => 'Pemetaan Risiko Geopolitik Kawasan Indo-Pasifik', 'en' => 'Geopolitical Risk Mapping of the Indo-Pacific Region'], 'is_featured' => true],
            ['title' => ['id' => 'Survey Persepsi Publik terhadap Reformasi Birokrasi', 'en' => 'Public Perception Survey on Bureaucratic Reform'], 'is_featured' => true],
            ['title' => ['id' => 'Analisis Dampak Kebijakan Subsidi Energi', 'en' => 'Impact Analysis of Energy Subsidy Policy'], 'is_featured' => false],
            ['title' => ['id' => 'Studi Kohesi Sosial di Wilayah Perkotaan', 'en' => 'Social Cohesion Study in Urban Areas'], 'is_featured' => false],
        ];

        foreach ($projects as $index => $project) {
            $slug = Str::slug($project['title']['id']);

            ResearchProject::updateOrCreate(['slug' => $slug], [
                ...$project,
                'slug' => $slug,
                'category_id' => $categoryIds->random(),
                'client' => 'Kementerian/Lembaga & Mitra Pembangunan',
                'year' => now()->year - rand(0, 2),
                'summary' => $summary,
                'content' => $content,
                'status' => 'published',
                'order' => $index,
            ]);
        }
    }
}
