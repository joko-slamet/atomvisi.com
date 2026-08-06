<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Infolists\Components as Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Inbox';

    protected static ?int $navigationSort = 1;

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
                Tables\Columns\TextColumn::make('name')
                    ->label('')
                    ->formatStateUsing(fn (string $state): string => strtoupper(mb_substr($state, 0, 1)))
                    ->badge()
                    ->color(fn ($record) => $record->is_read ? 'gray' : 'warning')
                    ->extraAttributes(['class' => 'flex h-9 w-9 items-center justify-center rounded-full text-sm']),
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? FontWeight::Medium : FontWeight::Bold)
                    ->description(fn ($record) => $record->email),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Pesan')
                    ->formatStateUsing(fn (?string $state) => $state ?: '(Tanpa subjek)')
                    ->weight(fn ($record) => $record->is_read ? null : FontWeight::SemiBold)
                    ->description(fn ($record) => str($record->message)->limit(70))
                    ->wrap(),
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
                    ->placeholder('Semua Pesan')
                    ->trueLabel('Sudah Dibaca')
                    ->falseLabel('Belum Dibaca'),
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
                            Infolists\TextEntry::make('name')
                                ->label('')
                                ->formatStateUsing(fn (string $state): string => strtoupper(mb_substr($state, 0, 1)))
                                ->badge()
                                ->color('warning')
                                ->size(Infolists\TextEntry\TextEntrySize::Large)
                                ->extraAttributes(['class' => 'flex h-12 w-12 items-center justify-center rounded-full'])
                                ->grow(false),
                            Infolists\Group::make([
                                Infolists\TextEntry::make('name')
                                    ->label('')
                                    ->weight(FontWeight::Bold)
                                    ->size(Infolists\TextEntry\TextEntrySize::Large),
                                Infolists\TextEntry::make('email')
                                    ->label('')
                                    ->icon('heroicon-o-envelope')
                                    ->color('gray')
                                    ->copyable(),
                                Infolists\TextEntry::make('phone')
                                    ->label('')
                                    ->icon('heroicon-o-phone')
                                    ->color('gray')
                                    ->copyable()
                                    ->visible(fn ($record) => filled($record->phone)),
                            ]),
                            Infolists\TextEntry::make('created_at')
                                ->label('')
                                ->dateTime('d M Y, H:i')
                                ->color('gray')
                                ->grow(false),
                        ])->from('md'),
                    ]),

                Infolists\Section::make()
                    ->schema([
                        Infolists\TextEntry::make('subject')
                            ->label('')
                            ->formatStateUsing(fn (?string $state) => $state ?: '(Tanpa subjek)')
                            ->weight(FontWeight::Bold)
                            ->size(Infolists\TextEntry\TextEntrySize::Large),
                        Infolists\TextEntry::make('message')
                            ->label('')
                            ->prose()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
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
