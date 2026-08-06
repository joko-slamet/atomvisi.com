<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function mount(int | string $record): void
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

            Actions\Action::make('reply')
                ->label('Balas via Email')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('primary')
                ->url(fn () => 'mailto:'.$this->record->email.'?subject='.rawurlencode('Re: '.($this->record->subject ?: 'Pesan dari '.$this->record->name)))
                ->openUrlInNewTab(),

            Actions\DeleteAction::make(),
        ];
    }
}
