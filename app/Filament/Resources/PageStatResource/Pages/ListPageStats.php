<?php

namespace App\Filament\Resources\PageStatResource\Pages;

use App\Filament\Resources\PageStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageStats extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = PageStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
