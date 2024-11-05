<?php

namespace App\Filament\Field\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use App\Models\DeliveryNote;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Field\Resources\DeliveryNoteResource;
use Illuminate\Support\Facades\Auth;

class ListDeliveryNotes extends ListRecords
{
    protected static string $resource = DeliveryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Surat Jalan')
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        // Get current logged in user's officer ID
        $user = Auth::user();
        $officer = $user->officer;

        if (!$officer) {
            return []; // Return empty tabs if user is not an officer
        }

        // Base query untuk delivery notes milik field officer yang login
        $baseQuery = DeliveryNote::where('field_officer_id', $officer->id);

        return [
            'all' => Tab::make('Semua')
                ->label('Semua')
                ->badge($officer->fieldDeliveryNotes()->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('field_officer_id', $officer->id)),

            'dibuat' => Tab::make('Dibuat')
                ->label('Dibuat')
                ->icon('heroicon-o-pencil')
                ->badge($officer->fieldDeliveryNotes()->where('status', 'dibuat')->count())
                ->badgeColor('secondary')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('field_officer_id', $officer->id)
                    ->where('status', 'dibuat')),

            'dikirim' => Tab::make('Dikirim')
                ->label('Dikirim')
                ->icon('heroicon-o-truck')
                ->badge($officer->fieldDeliveryNotes()->where('status', 'dikirim')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('field_officer_id', $officer->id)
                    ->where('status', 'dikirim')),

            'sampai' => Tab::make('Sampai')
                ->label('Sampai')
                ->icon('heroicon-o-check-circle')
                ->badge($officer->fieldDeliveryNotes()->where('status', 'sampai')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('field_officer_id', $officer->id)
                    ->where('status', 'sampai')),

            'selesai' => Tab::make('Selesai')
                ->label('Selesai')
                ->icon('heroicon-o-flag')
                ->badge($officer->fieldDeliveryNotes()->where('status', 'selesai')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('field_officer_id', $officer->id)
                    ->where('status', 'selesai')),
        ];
    }
}
