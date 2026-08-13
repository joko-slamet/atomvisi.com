<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageStatResource\Pages;
use App\Models\PageStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageStatResource extends Resource
{
    use Translatable;

    protected static ?string $model = PageStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'Statistik Homepage';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Label')
                    ->helperText('Contoh: "Riset Selesai", "Klien Institusi", "Tahun Pengalaman"')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->label('Nilai')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('suffix')
                    ->label('Akhiran')
                    ->helperText('Contoh: "+", "%"')
                    ->maxLength(10),
                Forms\Components\Select::make('icon')
                    ->label('Ikon')
                    ->options(ServiceResource::ICON_OPTIONS)
                    ->searchable()
                    ->native(false),
                Forms\Components\TextInput::make('order')
                    ->label('Urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif / Tampilkan')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state, $record) => $state.$record->suffix),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
            'index' => Pages\ListPageStats::route('/'),
            'create' => Pages\CreatePageStat::route('/create'),
            'edit' => Pages\EditPageStat::route('/{record}/edit'),
        ];
    }
}
