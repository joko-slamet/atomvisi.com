<?php

namespace App\Filament\Resources\ResearchProjectResource\Pages;

use App\Filament\Resources\ResearchProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResearchProject extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ResearchProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
