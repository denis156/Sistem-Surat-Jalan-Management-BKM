<?php

namespace App\Filament\Client\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DeliveryNote;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Client\Resources\DeliveryNoteResource\Pages;

class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Daftar Surat Jalan';

    protected static ?string $modelLabel = 'Daftar Surat Jalan';

    protected static ?string $slug = 'Daftar-Surat-Jalan';

    protected static ?string $pluralModelLabel = 'Daftar Surat Jalan';

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.'),
                // Informasi Dasar
                Tables\Columns\ColumnGroup::make('Informasi Dasar', [
                    Tables\Columns\TextColumn::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->searchable()
                        ->sortable()
                        ->copyable()
                        ->copyMessage('Nomor surat berhasil disalin!')
                        ->copyMessageDuration(1500)
                        ->tooltip('Klik untuk menyalin')
                        ->weight('bold'),

                    Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'dibuat' => 'gray',
                            'dikirim' => 'warning',
                            'sampai' => 'info',
                            'selesai' => 'success',
                        })
                        ->icon(fn(string $state): string => match ($state) {
                            'dibuat' => 'heroicon-o-pencil',
                            'dikirim' => 'heroicon-o-truck',
                            'sampai' => 'heroicon-o-check-circle',
                            'selesai' => 'heroicon-o-flag',
                            default => 'heroicon-o-question-mark-circle'
                        })
                        ->searchable()
                        ->sortable(),

                    Tables\Columns\IconColumn::make('print')
                        ->label('Dicetak')
                        ->boolean()
                        ->trueIcon('heroicon-o-check-circle')
                        ->falseIcon('heroicon-o-x-circle')
                        ->trueColor('success')
                        ->falseColor('danger'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Petugas
                Tables\Columns\ColumnGroup::make('Informasi Petugas', [
                    Tables\Columns\TextColumn::make('fieldOfficer.user.name')
                        ->label('Petugas Lapangan')
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true),

                    Tables\Columns\TextColumn::make('roomOfficer.user.name')
                        ->label('Petugas Ruangan')
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true),

                    Tables\Columns\TextColumn::make('warehouseOfficer.user.name')
                        ->label('Petugas Gudang')
                        ->searchable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Pengiriman
                Tables\Columns\ColumnGroup::make('Informasi Pengiriman', [
                    Tables\Columns\TextColumn::make('ship_to')
                        ->label('Tujuan')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'gudang kota' => 'success',
                            'gudang unaaha' => 'warning',
                            'gudang kolaka' => 'danger',
                        })
                        ->searchable(),

                    Tables\Columns\TextColumn::make('nama_driver')
                        ->label('Supir')
                        ->searchable()
                        ->sortable(),

                    Tables\Columns\TextColumn::make('nomor_plat')
                        ->label('Plat')
                        ->searchable()
                        ->sortable(),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Item
                Tables\Columns\ColumnGroup::make('Informasi Item', [
                    Tables\Columns\TextColumn::make('items.name_item')
                        ->label('Nama Item')
                        ->listWithLineBreaks()
                        ->bulleted(),

                    Tables\Columns\TextColumn::make('items.quantity')
                        ->label('Jumlah')
                        ->listWithLineBreaks(),

                    Tables\Columns\TextColumn::make('items.description')
                        ->label('Kondisi')
                        ->listWithLineBreaks(),

                    Tables\Columns\TextColumn::make('items_sum_quantity')
                        ->label('Jumlah Item')
                        ->getStateUsing(function (DeliveryNote $record) {
                            $total = 0;
                            foreach ($record->items as $item) {
                                if ($item->description === 'karung kurang') {
                                    $total -= $item->quantity;
                                } else {
                                    $total += $item->quantity;
                                }
                            }
                            return $total;
                        })
                        ->badge()
                        ->color('info'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Tanggal Dan Waktu
                Tables\Columns\ColumnGroup::make('Informasi Tanggal Dan Waktu', [
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Tgl. Dibuat')
                        ->dateTime('d M Y H:i')
                        ->color('secondary')
                        ->sortable(),

                    Tables\Columns\TextColumn::make('tanggal_pengiriman')
                        ->label('Tgl. Dikirim')
                        ->color('warning')
                        ->date('d M Y H:i')
                        ->sortable(),

                    Tables\Columns\TextColumn::make('tanggal_sampai')
                        ->label('Tgl. Sampai')
                        ->color('info')
                        ->date('d M Y H:i')
                        ->sortable(),

                    Tables\Columns\TextColumn::make('tanggal_bongkar')
                        ->label('Tgl. Selesai')
                        ->color('success')
                        ->date('d M Y H:i')
                        ->sortable(),

                    Tables\Columns\TextColumn::make('updated_at')
                        ->label('Tgl. Update')
                        ->dateTime('d M Y H:i')
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('ship_to')
                    ->label('Tujuan')
                    ->placeholder('Pilih Tujuan')
                    ->multiple()
                    ->options([
                        'gudang kota' => 'Gudang Kota',
                        'gudang unaaha' => 'Gudang Unaaha',
                        'gudang kolaka' => 'Gudang Kolaka',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->striped();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('client', function ($query) {
                $query->where('user_id', auth()->id());
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryNotes::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $userId = auth()->user()->client->id ?? null;

        if ($userId === null) {
            return null;
        }

        return static::getEloquentQuery()
            ->where('client_id', $userId)
            ->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah surat jalan di buat untukmu';
    }
}
