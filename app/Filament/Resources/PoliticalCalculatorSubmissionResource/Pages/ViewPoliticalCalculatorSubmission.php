<?php

namespace App\Filament\Resources\PoliticalCalculatorSubmissionResource\Pages;

use App\Filament\Resources\PoliticalCalculatorSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPoliticalCalculatorSubmission extends ViewRecord
{
    protected static string $resource = PoliticalCalculatorSubmissionResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (! $this->record->is_read) {
            $this->record->update(['is_read' => true]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggleRead')
                ->label(fn () => $this->record->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca')
                ->icon(fn () => $this->record->is_read ? 'heroicon-o-envelope' : 'heroicon-o-envelope-open')
                ->color('gray')
                ->action(fn () => $this->record->update(['is_read' => ! $this->record->is_read])),

            Actions\DeleteAction::make(),
        ];
    }
}
