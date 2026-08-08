<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.site-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon / WhatsApp')
                            ->required()
                            ->helperText('Dipakai untuk tombol telepon & WhatsApp di website. Contoh: 6282191292596'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('WhatsApp')
                    ->schema([
                        Forms\Components\Textarea::make('whatsapp_message')
                            ->label('Pesan Default Tombol WhatsApp')
                            ->rows(2),
                    ]),

                Forms\Components\Section::make('Peta')
                    ->schema([
                        Forms\Components\Textarea::make('map_embed_url')
                            ->label('URL Embed Google Maps')
                            ->helperText('Buka Google Maps → Bagikan → Sematkan peta, lalu salin URL dari atribut src pada kode iframe.')
                            ->rows(2),
                    ]),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                        Forms\Components\TextInput::make('facebook_url')->label('Facebook')->url(),
                        Forms\Components\TextInput::make('tiktok_url')->label('TikTok')->url(),
                        Forms\Components\TextInput::make('linkedin_url')->label('LinkedIn')->url(),
                        Forms\Components\TextInput::make('youtube_url')->label('YouTube')->url(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::current()->update($data);

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
