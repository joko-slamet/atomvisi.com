<?php

namespace App\Filament\Pages;

use App\Models\PoliticalCalculatorSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PoliticalCalculatorSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationLabel = 'Pengaturan Kalkulator';

    protected static ?string $title = 'Pengaturan Kalkulator Politik';

    protected static ?int $navigationSort = 101;

    protected static string $view = 'filament.pages.political-calculator-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(PoliticalCalculatorSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_enabled')
                            ->label('Aktifkan Kalkulator Politik')
                            ->helperText('Jika dimatikan, pengunjung akan melihat pesan bahwa fitur sedang tidak tersedia.'),
                    ]),

                Forms\Components\Section::make('Model AI')
                    ->schema([
                        Forms\Components\TextInput::make('model')
                            ->label('Model OpenRouter (opsional)')
                            ->placeholder(config('services.openrouter.model', 'google/gemini-2.5-flash'))
                            ->helperText('Kosongkan untuk memakai model default dari OPENROUTER_MODEL di .env.'),
                    ]),

                Forms\Components\Section::make('Batas Penggunaan')
                    ->description('Mencegah penyalahgunaan karena setiap submission memanggil OpenRouter (berbayar).')
                    ->schema([
                        Forms\Components\TextInput::make('max_submissions_per_ip_per_day')
                            ->label('Maksimal Percobaan per IP per Hari')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(50),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PoliticalCalculatorSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
