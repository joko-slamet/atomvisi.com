<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    use Translatable;

    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 3;

    public const ICON_OPTIONS = [
        'heroicon-o-scale' => 'Timbangan (Kebijakan)',
        'heroicon-o-globe-alt' => 'Globe (Geopolitik)',
        'heroicon-o-chart-bar' => 'Grafik Batang (Survey)',
        'heroicon-o-light-bulb' => 'Bola Lampu (Strategi)',
        'heroicon-o-document-text' => 'Dokumen (Policy Brief)',
        'heroicon-o-calendar-days' => 'Kalender (Event/Workshop)',
        'heroicon-o-users' => 'Kelompok Orang',
        'heroicon-o-magnifying-glass' => 'Kaca Pembesar (Riset)',
        'heroicon-o-chat-bubble-left-right' => 'Diskusi',
        'heroicon-o-presentation-chart-line' => 'Presentasi',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Layanan')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('parent_id')
                            ->label('Bagian dari Layanan (opsional)')
                            ->helperText('Kosongkan untuk layanan utama. Pilih induk untuk menjadikannya sub-layanan.')
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query, ?Service $record) => $query
                                    ->whereNull('parent_id')
                                    ->when($record, fn ($q) => $q->whereKeyNot($record->getKey())),
                            )
                            ->getOptionLabelFromRecordUsing(fn (Service $record) => $record->name)
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->helperText('Tampil di card ringkasan layanan pada homepage.')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Tampilan')
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Forms\Components\Select::make('icon')
                            ->label('Ikon')
                            ->options(self::ICON_OPTIONS)
                            ->searchable()
                            ->native(false),
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('services')
                            ->imageEditor(),
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif / Tampilkan')
                            ->default(true),
                    ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->disk('public')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->description(fn (Service $record) => $record->parent?->name ? 'Sub-layanan dari: '.$record->parent->name : null)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->limit(50),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
                Tables\Filters\TernaryFilter::make('parent_id')
                    ->label('Jenis')
                    ->placeholder('Semua')
                    ->trueLabel('Hanya sub-layanan')
                    ->falseLabel('Hanya layanan utama')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('parent_id'),
                        false: fn ($query) => $query->whereNull('parent_id'),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
