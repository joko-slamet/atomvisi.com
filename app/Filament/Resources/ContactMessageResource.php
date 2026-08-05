<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Pesan Kontak';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Telepon')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->label('Subjek')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label('Pesan')
                    ->disabled()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_read')
                    ->label('Sudah Dibaca'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_read ? 'normal' : 'bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->limit(40),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Sudah Dibaca'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Lihat'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
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
