<?php

namespace App\Filament\Field\Resources\DeliveryNoteResource\Pages;

use App\Models\DeliveryNote;
use Filament\Actions;
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
        ];
    }

    public function getTitle(): string
    {
        return "Surat Jalan: {$this->record->nomor_surat}";
    }
}
