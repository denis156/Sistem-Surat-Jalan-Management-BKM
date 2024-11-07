<?php

namespace App\Filament\Warehouse\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use App\Models\DeliveryNote;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Warehouse\Resources\DeliveryNoteResource;

class ListDeliveryNotes extends ListRecords
{
    protected static string $resource = DeliveryNoteResource::class;

    public function getTabs(): array
    {
        // Get current logged in user's officer ID
        $user = Auth::user();
        $officer = $user->officer;

        if (!$officer) {
            return []; // Return empty tabs if user is not an officer
        }

        DeliveryNote::where('warehouse_officer_id', $officer->id);

        return [
            'dikirim' => Tab::make('Dikirim')
                ->label('Dikirim')
                ->icon('heroicon-o-truck')
                ->badge($officer->warehouseDeliveryNotes()->where('status', 'dikirim')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('warehouse_officer_id', $officer->id)
                    ->where('status', 'dikirim')),

            'sampai' => Tab::make('Sampai')
                ->label('Sampai')
                ->icon('heroicon-o-check-circle')
                ->badge($officer->warehouseDeliveryNotes()->where('status', 'sampai')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('warehouse_officer_id', $officer->id)
                    ->where('status', 'sampai')),

            'selesai' => Tab::make('Selesai')
                ->label('Selesai')
                ->icon('heroicon-o-flag')
                ->badge($officer->warehouseDeliveryNotes()->where('status', 'selesai')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('warehouse_officer_id', $officer->id)
                    ->where('status', 'selesai')),
        ];
    }
}
