<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoliticalCalculatorSubmissionResource\Pages;
use App\Models\PoliticalCalculatorSubmission;
use Filament\Infolists\Components as Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class PoliticalCalculatorSubmissionResource extends Resource
{
    protected static ?string $model = PoliticalCalculatorSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationLabel = 'Kalkulator Politik';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-s-envelope')
                    ->trueColor('gray')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('provinsi')
                    ->label('Wilayah')
                    ->searchable(['provinsi', 'kota'])
                    ->weight(fn ($record) => $record->is_read ? FontWeight::Medium : FontWeight::Bold)
                    ->formatStateUsing(fn ($record) => $record->region_label),
                Tables\Columns\TextColumn::make('target_jabatan')
                    ->label('Target Jabatan')
                    ->formatStateUsing(fn ($record) => $record->target_jabatan_label)
                    ->badge(),
                Tables\Columns\TextColumn::make('jumlah_pemilih_potensial')
                    ->label('Pemilih Potensial')
                    ->formatStateUsing(fn (?int $state) => $state ? Number::format($state) : '-')
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at->format('d M Y, H:i'))
                    ->color('gray')
                    ->sortable()
                    ->alignEnd(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Status')
                    ->placeholder('Semua Submission')
                    ->trueLabel('Sudah Dibaca')
                    ->falseLabel('Belum Dibaca'),
                Tables\Filters\SelectFilter::make('target_jabatan')
                    ->label('Target Jabatan')
                    ->options([
                        'gubernur' => 'Gubernur',
                        'walikota' => 'Walikota',
                        'bupati' => 'Bupati',
                        'caleg' => 'Caleg',
                    ]),
            ])
            ->recordUrl(fn ($record) => static::getUrl('view', ['record' => $record]))
            ->recordClasses(fn ($record) => $record->is_read ? null : 'bg-warning-50 dark:bg-warning-500/5')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markRead')
                        ->label('Tandai Sudah Dibaca')
                        ->icon('heroicon-o-envelope-open')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->update(['is_read' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('markUnread')
                        ->label('Tandai Belum Dibaca')
                        ->icon('heroicon-s-envelope')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->update(['is_read' => false]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Section::make()
                    ->schema([
                        Infolists\Split::make([
                            Infolists\Group::make([
                                Infolists\TextEntry::make('provinsi')
                                    ->label('')
                                    ->formatStateUsing(fn ($record) => $record->region_label)
                                    ->weight(FontWeight::Bold)
                                    ->size(Infolists\TextEntry\TextEntrySize::Large),
                                Infolists\TextEntry::make('target_jabatan')
                                    ->label('')
                                    ->formatStateUsing(fn ($record) => $record->target_jabatan_label)
                                    ->badge(),
                            ]),
                            Infolists\TextEntry::make('created_at')
                                ->label('')
                                ->dateTime('d M Y, H:i')
                                ->color('gray')
                                ->grow(false),
                        ])->from('md'),
                    ]),

                Infolists\Section::make('Profil Kandidat')
                    ->schema([
                        Infolists\TextEntry::make('age_range')
                            ->label('Rentang Usia')
                            ->formatStateUsing(fn ($record) => $record->age_range_label ?? '-'),
                        Infolists\TextEntry::make('candidate_status')
                            ->label('Status Pencalonan')
                            ->formatStateUsing(fn ($record) => $record->candidate_status_label ?? '-'),
                        Infolists\TextEntry::make('public_recognition')
                            ->label('Tingkat Pengenalan Publik')
                            ->formatStateUsing(fn ($record) => $record->public_recognition_label ?? '-'),
                        Infolists\TextEntry::make('voter_target')
                            ->label('Kelompok Masyarakat Prioritas')
                            ->formatStateUsing(fn ($record) => $record->voter_target_label ?? '-'),
                        Infolists\TextEntry::make('main_goal')
                            ->label('Prioritas Sosialisasi')
                            ->formatStateUsing(fn ($record) => $record->main_goal_label ?? '-'),
                        Infolists\TextEntry::make('local_issues')
                            ->label('Isu Utama')
                            ->formatStateUsing(fn ($record) => filled($record->local_issues_labels) ? implode(', ', $record->local_issues_labels) : '-'),
                        Infolists\TextEntry::make('about_you')
                            ->label('Tentang Kandidat')
                            ->formatStateUsing(fn (?string $state) => $state ?: '-')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Infolists\Section::make('Demografi')
                    ->schema([
                        Infolists\TextEntry::make('jumlah_penduduk')
                            ->label('Jumlah Penduduk')
                            ->formatStateUsing(fn (?int $state) => $state ? Number::format($state) : '-'),
                        Infolists\TextEntry::make('jumlah_pemilih_potensial')
                            ->label('Jumlah Pemilih Potensial')
                            ->formatStateUsing(fn (?int $state) => $state ? Number::format($state) : '-'),
                        Infolists\TextEntry::make('kelompok_umur_dominan')
                            ->label('Kelompok Umur yang Mendominasi'),
                    ])
                    ->columns(3),

                Infolists\Section::make('Langkah Strategis')
                    ->schema([
                        Infolists\TextEntry::make('langkah_strategis')
                            ->label('')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->columnSpanFull(),
                    ]),

                Infolists\Section::make('Pembagian Porsi Komunikasi')
                    ->schema([
                        Infolists\TextEntry::make('porsi_komunikasi.baliho')->label('Baliho')->suffix('%'),
                        Infolists\TextEntry::make('porsi_komunikasi.sosialisasi_kunjungan')->label('Sosialisasi & Kunjungan')->suffix('%'),
                        Infolists\TextEntry::make('porsi_komunikasi.instagram')->label('Instagram')->suffix('%'),
                        Infolists\TextEntry::make('porsi_komunikasi.whatsapp')->label('WhatsApp')->suffix('%'),
                    ])
                    ->columns(4),

                Infolists\Section::make('Roadmap 1 Tahun')
                    ->schema([
                        Infolists\ViewEntry::make('roadmap')
                            ->label('')
                            ->view('filament.infolists.political-calculator-roadmap')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPoliticalCalculatorSubmissions::route('/'),
            'view' => Pages\ViewPoliticalCalculatorSubmission::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}
