<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    use Translatable;

    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')
                    ->label('Nama Klien')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('client_role')
                    ->label('Jabatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('client_company')
                    ->label('Instansi / Perusahaan')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->avatar()
                    ->directory('testimonials'),
                Forms\Components\Textarea::make('quote')
                    ->label('Kutipan')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Select::make('rating')
                    ->options(['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'])
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
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular(),
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Nama Klien')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_company')
                    ->label('Instansi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
