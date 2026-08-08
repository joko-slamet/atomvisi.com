<?php

namespace App\Filament\Resources\ResearchProjectResource\Pages;

use App\Filament\Resources\ResearchProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResearchProject extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = ResearchProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
