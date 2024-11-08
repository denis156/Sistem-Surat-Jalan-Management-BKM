<?php

namespace App\Filament\Client\Resources\DeliveryNoteResource\Pages;

use App\Models\DeliveryNote;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Client\Resources\DeliveryNoteResource;

class ListDeliveryNotes extends ListRecords
{
    protected static string $resource = DeliveryNoteResource::class;

    public function getTabs(): array
    {
        $user = Auth::user();
        $client = $user->client;

        if (!$client) {
            return [];
        }

        return [
            'all' => Tab::make('Semua')
                ->label('Semua')
                ->badge($client->deliveryNotes()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->where('client_id', $client->id)),

            'dibuat' => Tab::make('Dibuat')
                ->label('Dibuat')
                ->icon('heroicon-o-pencil')
                ->badge($client->deliveryNotes()->where('status', 'dibuat')->count())
                ->badgeColor('secondary')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->where('client_id', $client->id)
                    ->where('status', 'dibuat')),

            'dikirim' => Tab::make('Dikirim')
                ->label('Dikirim')
                ->icon('heroicon-o-truck')
                ->badge($client->deliveryNotes()->where('status', 'dikirim')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->where('client_id', $client->id)
                    ->where('status', 'dikirim')),

            'sampai' => Tab::make('Sampai')
                ->label('Sampai')
                ->icon('heroicon-o-check-circle')
                ->badge($client->deliveryNotes()->where('status', 'sampai')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->where('client_id', $client->id)
                    ->where('status', 'sampai')),

            'selesai' => Tab::make('Selesai')
                ->label('Selesai')
                ->icon('heroicon-o-flag')
                ->badge($client->deliveryNotes()->where('status', 'selesai')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query
                    ->where('client_id', $client->id)
                    ->where('status', 'selesai')),
        ];
    }
}
