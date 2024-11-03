<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\DeliveryNoteResource\Pages;
use App\Models\DeliveryNote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Surat Jalan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Surat Jalan')
                    ->schema([
                        Forms\Components\TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->disabled(),

                        Forms\Components\Select::make('field_officer_id')
                            ->label('Field Officer')
                            ->relationship('fieldOfficer.user', 'name')
                            ->disabled(),

                        Forms\Components\DatePicker::make('tanggal_pengiriman')
                            ->label('Tanggal Pengiriman')
                            ->disabled(),

                        Forms\Components\TimePicker::make('waktu_pengiriman')
                            ->label('Waktu Pengiriman')
                            ->disabled(),

                        Forms\Components\Select::make('ship_to')
                            ->label('Tujuan Pengiriman')
                            ->options([
                                'gudang kota' => 'Gudang Kota',
                                'gudang unaaha' => 'Gudang Unaaha',
                                'gudang kolaka' => 'Gudang Kolaka',
                            ])
                            ->disabled(),

                        Forms\Components\TextInput::make('nomor_plat')
                            ->label('Nomor Plat')
                            ->disabled(),

                        Forms\Components\TextInput::make('nama_driver')
                            ->label('Nama Driver')
                            ->disabled(),

                        Forms\Components\Select::make('palka')
                            ->label('Palka')
                            ->options([
                                'palka 1' => 'Palka 1',
                                'palka 2' => 'Palka 2',
                            ])
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('name_item')
                                    ->label('Nama Item')
                                    ->disabled(),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->disabled(),

                                Forms\Components\Select::make('description')
                                    ->label('Kondisi')
                                    ->options([
                                        'utuh' => 'Utuh',
                                        'robek kapal' => 'Robek Kapal',
                                        'basah kapal' => 'Basah Kapal',
                                        'robek truck' => 'Robek Truck',
                                        'basah truck' => 'Basah Truck',
                                        'robek pbm' => 'Robek PBM',
                                        'basah pbm' => 'Basah PBM',
                                        'karung lebih' => 'Karung Lebih',
                                        'karung kurang' => 'Karung Kurang',
                                    ])
                                    ->disabled(),
                            ])
                            ->disabled()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['name_item'] ?? null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fieldOfficer.user.name')
                    ->label('Field Officer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pengiriman')
                    ->label('Tanggal Pengiriman')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_sampai')
                    ->label('Tanggal Sampai')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ship_to')
                    ->label('Tujuan'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'dibuat',
                        'warning' => 'dikirim',
                        'info' => 'sampai',
                        'success' => 'selesai',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'dibuat' => 'Dibuat',
                        'dikirim' => 'Dikirim',
                        'sampai' => 'Sampai',
                        'selesai' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Cetak')
                    ->icon('heroicon-o-printer')
                    ->visible(fn (DeliveryNote $record) => !$record->print)
                    ->action(function (DeliveryNote $record) {
                        $record->update(['print' => true]);
                        // Add your print logic here
                    }),
            ]);
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
            // 'view' => Pages\ViewDeliveryNote::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('status', 'dibuat')->count();
    }
}
