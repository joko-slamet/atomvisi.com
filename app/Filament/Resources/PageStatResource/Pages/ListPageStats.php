<?php

namespace App\Filament\Resources\PageStatResource\Pages;

use App\Filament\Resources\PageStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageStats extends ListRecords
{
    protected static string $resource = PageStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
