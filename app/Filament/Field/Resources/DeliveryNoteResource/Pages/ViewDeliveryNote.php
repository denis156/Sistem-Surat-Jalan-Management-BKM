<?php

namespace App\Filament\Field\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use App\Models\DeliveryNote;
use Filament\Resources\Pages\Page;
use App\Filament\Field\Resources\DeliveryNoteResource;

class ViewDeliveryNote extends Page
{
    protected static string $resource = DeliveryNoteResource::class;

    protected static string $view = 'filament.field.resources.delivery-note-resource.pages.view-delivery-note';

    public DeliveryNote $record;

    public function mount(DeliveryNote $record): void
    {
        $this->record = $record->load([
            'client.user',
            'fieldOfficer.user',
            'roomOfficer.user',
            'warehouseOfficer.user',
            'items'
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('secondary')
                ->icon('heroicon-o-arrow-left'),

            Actions\Action::make('edit')
                ->label('Edit')
                ->url(fn() => $this->getResource()::getUrl('edit', ['record' => $this->record->getKey()]))
                ->color('success')
                ->icon('heroicon-o-pencil')
                ->visible(fn() => $this->record && $this->record->status === 'dibuat'),
        ];
    }

    public function getTitle(): string
    {
        return "Surat Jalan: {$this->record->nomor_surat}";
    }
}
