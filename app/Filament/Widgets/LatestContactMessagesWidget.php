<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestContactMessagesWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected static ?string $heading = 'Pesan Masuk Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(ContactMessage::query()->latest()->limit(5))
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->weight(fn ($record) => $record->is_read ? FontWeight::Medium : FontWeight::Bold)
                    ->description(fn ($record) => $record->email),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Pesan')
                    ->formatStateUsing(fn (?string $state) => $state ?: '(Tanpa subjek)')
                    ->description(fn ($record) => str($record->message)->limit(60))
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->since()
                    ->color('gray')
                    ->alignEnd(),
            ])
            ->recordUrl(fn ($record) => ContactMessageResource::getUrl('view', ['record' => $record]))
            ->emptyStateHeading('Belum ada pesan masuk')
            ->emptyStateIcon('heroicon-o-envelope');
    }
}
