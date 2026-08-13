<?php

namespace App\Filament\Resources\PoliticalCalculatorSubmissionResource\Pages;

use App\Filament\Resources\PoliticalCalculatorSubmissionResource;
use Filament\Resources\Pages\ListRecords;

class ListPoliticalCalculatorSubmissions extends ListRecords
{
    protected static string $resource = PoliticalCalculatorSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
