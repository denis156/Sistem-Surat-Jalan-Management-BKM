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
                                ->default(fn () => auth()->user()->officer->id),
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
                                ->visible(fn (callable $get) => $get('status') === 'selesai'),

                            Forms\Components\TimePicker::make('waktu_bongkar')
                                ->label('Waktu Bongkar')
                                ->required()
                                ->visible(fn (callable $get) => $get('status') === 'selesai'),
                        ]),
                ])->skippable(),
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

                Tables\Columns\TextColumn::make('client.company_name')
                    ->label('Client')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pengiriman')
                    ->label('Tanggal Pengiriman')
                    ->date(),

                Tables\Columns\TextColumn::make('tanggal_sampai')
                    ->label('Tanggal Sampai')
                    ->date(),

                Tables\Columns\TextColumn::make('ship_to')
                    ->label('Tujuan'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'dikirim',
                        'info' => 'sampai',
                        'success' => 'selesai',
                    ]),
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
                    ->visible(fn (DeliveryNote $record) => $record->status !== 'selesai'),
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
