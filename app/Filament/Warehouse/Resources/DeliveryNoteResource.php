<?php

namespace App\Filament\Warehouse\Resources;

use App\Filament\Warehouse\Resources\DeliveryNoteResource\Pages;
use App\Filament\Warehouse\Resources\DeliveryNoteResource\RelationManagers;
use App\Models\DeliveryNote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\Builder;

class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Penerimaan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Surat Jalan')
                        ->schema([
                            Forms\Components\TextInput::make('nomor_surat')
                                ->label('Nomor Surat')
                                ->disabled(),

                            Forms\Components\Select::make('client_id')
                                ->label('Client')
                                ->relationship('client', 'company_name')
                                ->disabled(),

                            Forms\Components\Select::make('field_officer_id')
                                ->label('Field Officer')
                                ->relationship('fieldOfficer', 'employee_id')
                                ->disabled(),

                            Forms\Components\Hidden::make('warehouse_officer_id')
                                ->default(fn() => auth()->user()->officer->id),
                        ]),

                    Step::make('Detail Pengiriman')
                        ->schema([
                            Forms\Components\DatePicker::make('tanggal_pengiriman')
                                ->label('Tanggal Pengiriman')
                                ->disabled(),

                            Forms\Components\TimePicker::make('waktu_pengiriman')
                                ->label('Waktu Pengiriman')
                                ->disabled(),

                            Forms\Components\Select::make('ship_to')
                                ->label('Tujuan Pengiriman')
                                ->disabled()
                                ->options([
                                    'gudang kota' => 'Gudang Kota',
                                    'gudang unaaha' => 'Gudang Unaaha',
                                    'gudang kolaka' => 'Gudang Kolaka',
                                ]),
                        ]),

                    Step::make('Items')
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
                                        ->required(),
                                ])
                                ->addActionLabel('Tambah Item'),
                        ]),

                    Step::make('Status Penerimaan')
                        ->schema([
                            Forms\Components\Select::make('status')
                                ->label('Status')
                                ->options([
                                    'dikirim' => 'Dikirim',
                                    'sampai' => 'Sampai',
                                    'selesai' => 'Selesai',
                                ])
                                ->required(),

                            Forms\Components\DatePicker::make('tanggal_sampai')
                                ->label('Tanggal Sampai')
                                ->required()
                                ->default(now()),

                            Forms\Components\TimePicker::make('waktu_sampai')
                                ->label('Waktu Sampai')
                                ->required()
                                ->default(now()),

                            Forms\Components\DatePicker::make('tanggal_bongkar')
                                ->label('Tanggal Bongkar')
                                ->required()
                                ->visible(fn(callable $get) => $get('status') === 'selesai'),

                            Forms\Components\TimePicker::make('waktu_bongkar')
                                ->label('Waktu Bongkar')
                                ->required()
                                ->visible(fn(callable $get) => $get('status') === 'selesai'),
                        ]),
                ])->skippable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.'),

                Tables\Columns\TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Nomor surat berhasil disalin!')
                    ->copyMessageDuration(1500)
                    ->tooltip('Klik untuk menyalin')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('client.user.name')
                    ->label('Klien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_sum_quantity')
                    ->label('Jumlah Item')
                    ->sum('items', 'quantity')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('fieldOfficer.user.name')
                    ->label('Petugas Lapangan')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tgl. Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('roomOfficer.user.name')
                    ->label('Petugas Ruangan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('ship_to')
                    ->label('Tujuan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'gudang kota' => 'success',
                        'gudang unaaha' => 'warning',
                        'gudang kolaka' => 'danger',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pengiriman')
                    ->label('Tgl. Dikirim')
                    ->date('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('warehouseOfficer.user.name')
                    ->label('Petugas Gudang')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tgl. Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'dikirim' => 'Dikirim',
                        'sampai' => 'Sampai',
                        'selesai' => 'Selesai',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn(DeliveryNote $record) => $record->status !== 'selesai'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', ['dikirim', 'sampai'])
            ->orWhere(function ($query) {
                $query->where('status', 'selesai')
                    ->where('warehouse_officer_id', auth()->user()->officer->id);
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryNotes::route('/'),
            'edit' => Pages\EditDeliveryNote::route('/{record}/edit'),
        ];
    }
}
