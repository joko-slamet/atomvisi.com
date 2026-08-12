<?php

namespace App\Filament\Pages;

use App\Models\AiArticleSetting;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class AiArticleSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'AI Artikel';

    protected static ?string $title = 'Pengaturan AI Artikel';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.ai-article-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $settings = AiArticleSetting::current();

        $this->form->fill([
            ...$settings->toArray(),
            'run_times' => $settings->run_times ?? [],
        ]);
    }

    public function form(Form $form): Form
    {
        $settings = AiArticleSetting::current();

        return $form
            ->schema([
                Forms\Components\Section::make('Jadwal Otomatis')
                    ->description('Atur jam berapa saja artikel di-generate otomatis setiap hari. Satu jadwal jam = satu artikel draft, dibuat untuk direview sebelum dipublikasikan.')
                    ->schema([
                        Forms\Components\Toggle::make('is_scheduler_enabled')
                            ->label('Aktifkan generate otomatis')
                            ->live(),
                        Forms\Components\Repeater::make('run_times')
                            ->label('Jam Generate')
                            ->simple(
                                Forms\Components\TimePicker::make('time')
                                    ->seconds(false)
                                    ->format('H:i')
                                    ->displayFormat('H:i')
                                    ->required()
                            )
                            ->addActionLabel('+ Tambah Jam')
                            ->reorderable(false)
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->visible(fn (Forms\Get $get) => $get('is_scheduler_enabled')),
                        Forms\Components\Placeholder::make('last_run_at_display')
                            ->label('Terakhir Dijalankan')
                            ->content($settings->last_run_at?->translatedFormat('d M Y, H:i') ?? 'Belum pernah')
                            ->visible(fn (Forms\Get $get) => $get('is_scheduler_enabled')),
                    ]),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Jenis Artikel')
                            ->options([
                                'article' => 'Artikel / Blog',
                                'op-ed' => 'Op-Ed',
                                'newsletter' => 'Newsletter',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori Default')
                            ->options(fn () => Category::query()->get()->pluck('name', 'id'))
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('topics')
                            ->label('Daftar Topik (satu topik per baris)')
                            ->rows(6)
                            ->helperText('Setiap kali generate otomatis berjalan, topik akan dipilih secara acak dari daftar ini.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('runNow')
                ->label('Jalankan Sekarang')
                ->icon('heroicon-o-play')
                ->color('gray')
                ->requiresConfirmation()
                ->modalDescription('Ini akan langsung generate 1 artikel draft baru dari topik yang dikonfigurasi (di luar jadwal).')
                ->action(function () {
                    $this->save(silent: true);

                    Artisan::call('articles:generate-ai', ['--force' => true]);

                    Notification::make()
                        ->title('Generate selesai')
                        ->body(trim(Artisan::output()))
                        ->success()
                        ->send();
                }),
        ];
    }

    public function save(bool $silent = false): void
    {
        $data = $this->form->getState();

        $data['run_times'] = collect($data['run_times'] ?? [])
            ->filter()
            ->unique()
            ->values()
            ->all();

        AiArticleSetting::current()->update($data);

        if (! $silent) {
            Notification::make()
                ->title('Pengaturan berhasil disimpan')
                ->success()
                ->send();
        }
    }
}
