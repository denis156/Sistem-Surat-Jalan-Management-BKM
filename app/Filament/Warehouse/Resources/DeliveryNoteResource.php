<?php

namespace App\Filament\Warehouse\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryNote;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\Alignment;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Warehouse\Resources\DeliveryNoteResource\Pages;
use App\Filament\Warehouse\Resources\DeliveryNoteResource\RelationManagers;

class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Penerimaan Surat Jalan';

    protected static ?string $modelLabel = 'Penerimaan Surat Jalan';

    protected static ?string $slug = 'Penerimaan-Surat-Jalan';

    protected static ?string $pluralModelLabel = 'Penerimaan Surat Jalan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi Dasar')
                        ->icon('heroicon-o-information-circle')
                        ->description('Informasi dasar surat jalan')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('nomor_surat')
                                                ->label('Nomor Surat')
                                                ->disabled()
                                                ->helperText('Nomor surat akan digenerate otomatis')
                                                ->maxLength(255),

                                            Forms\Components\Select::make('client_id')
                                                ->label('Klien')
                                                ->relationship(
                                                    'client',
                                                    'company_name',
                                                    fn(Builder $query) => $query
                                                        ->where('is_active', true)
                                                        ->whereHas('user', fn(Builder $subQuery) => $subQuery->where('role', 'client'))
                                                        ->with('user')
                                                )
                                                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->user->name} - {$record->company_name}")
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->disabled(),

                                            Forms\Components\Select::make('status')
                                                ->label('Status')
                                                ->options([
                                                    'sampai' => 'Sampai',
                                                    'selesai' => 'Selesai',
                                                ])
                                                ->disabled()
                                                ->native(false)
                                                ->required(),
                                        ])
                                        ->columns(3),
                                ]),
                        ]),

                    Step::make('Detail Pengiriman')
                        ->icon('heroicon-o-truck')
                        ->description('Informasi detail pengiriman')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\Select::make('ship_to')
                                                ->label('Tujuan Pengiriman')
                                                ->options([
                                                    'gudang kota' => 'Gudang Kota',
                                                    'gudang unaaha' => 'Gudang Unaaha',
                                                    'gudang kolaka' => 'Gudang Kolaka',
                                                ])
                                                ->native(false)
                                                ->required()
                                                ->disabled(),

                                            Forms\Components\Select::make('palka')
                                                ->label('Palka')
                                                ->options([
                                                    'palka 1' => 'Palka 1',
                                                    'palka 2' => 'Palka 2',
                                                ])
                                                ->native(false)
                                                ->required()
                                                ->disabled(),
                                        ])->columns(2),

                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('nomor_plat')
                                                ->label('Nomor Plat')
                                                ->required()
                                                ->maxLength(255)
                                                ->disabled(),

                                            Forms\Components\TextInput::make('nama_driver')
                                                ->label('Nama Driver')
                                                ->required()
                                                ->maxLength(255)
                                                ->disabled(),
                                        ])->columns(2),
                                ]),
                        ]),

                    Step::make('Items')
                        ->icon('heroicon-o-cube')
                        ->description('Daftar item yang akan dikirim')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Repeater::make('items')
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\Grid::make()
                                                ->schema([
                                                    Forms\Components\TextInput::make('name_item')
                                                        ->label('Nama Item')
                                                        ->required()
                                                        ->default('Beras 50Kg/Karung')
                                                        ->maxLength(255),

                                                    Forms\Components\TextInput::make('quantity')
                                                        ->label('Jumlah')
                                                        ->numeric()
                                                        ->required()
                                                        ->minValue(1),

                                                    Forms\Components\Select::make('description')
                                                        ->label('Kondisi')
                                                        ->options([
                                                            'utuh' => 'Utuh',
                                                            'robek kapal' => 'Robek Kapal',
                                                            'basah kapal' => 'Basah Kapal',
                                                            'robek pbm' => 'Robek PBM',
                                                            'basah pbm' => 'Basah PBM',
                                                        ])
                                                        ->default('utuh')
                                                        ->native(false)
                                                        ->required(),
                                                ])->columns(3),
                                        ])
                                        ->defaultItems(1)
                                        ->addActionLabel('Tambah Item')
                                        ->reorderable()
                                        ->collapsible()
                                        ->cloneable()
                                        ->itemLabel(fn(array $state): ?string => $state['name_item'] ?? null),
                                ]),
                        ]),
                ])
                    ->skippable()
                    ->persistStepInQueryString()
                    ->columnSpanFull()
                    ->startOnStep(3),
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

                // Informasi Klien
                Tables\Columns\ColumnGroup::make('Informasi Klien', [
                    Tables\Columns\TextColumn::make('client.user.name')
                        ->label('Nama PIC')
                        ->searchable()
                        ->sortable(),

                    Tables\Columns\TextColumn::make('client.company_name')
                        ->label('Perusahaan PIC')
                        ->searchable()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
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
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->button()
                    ->color('secondary')
                    ->icon('heroicon-o-eye')
                    ->url(fn(DeliveryNote $record) => route('filament.warehouse.resources.Penerimaan-Surat-Jalan.view', $record)),
                Tables\Actions\Action::make('sampai')
                    ->label('Sampai')
                    ->visible(fn(DeliveryNote $record) => $record->status === 'dikirim')
                    ->color('info')
                    ->button()
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Status Sampai')
                    ->modalDescription('Apakah Anda yakin ingin mengubah status surat jalan ini menjadi "sampai"?')
                    ->modalSubmitActionLabel('Ya, Ubah')
                    ->action(function (DeliveryNote $record) {
                        $record->update([
                            'status' => 'sampai',
                            'tanggal_sampai' => now(),
                        ]);
                        Notification::make()
                            ->title('Status Diubah ke Sampai')
                            ->body("Surat jalan nomor {$record->nomor_surat} telah ditandai sebagai sampai.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('selesai')
                    ->label('Selesai')
                    ->visible(fn(DeliveryNote $record) => $record->status === 'sampai')
                    ->color('success')
                    ->button()
                    ->icon('heroicon-o-flag')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Status Selesai')
                    ->modalDescription('Apakah Anda yakin ingin mengubah status surat jalan ini menjadi "selesai"?')
                    ->modalSubmitActionLabel('Ya, Selesai')
                    ->action(function (DeliveryNote $record) {
                        $record->update([
                            'status' => 'selesai',
                            'tanggal_bongkar' => now(),
                        ]);

                        Notification::make()
                            ->title('Status Diubah ke Selesai')
                            ->body("Surat jalan nomor {$record->nomor_surat} telah ditandai sebagai selesai.")
                            ->success()
                            ->send();
                    }),
            ])
            ->emptyStateHeading('Belum ada surat jalan dikirim')
            ->emptyStateDescription('Tunggu petugas ruangan untuk mencetak surat jalan yang akan dikirimkan')
            ->emptyStateIcon('heroicon-o-document-text')
            ->striped();
    }

    public static function getEloquentQuery(): Builder
    {
        // Menampilkan hanya data yang dibuat oleh warehouse_officer yang login
        return parent::getEloquentQuery()
            ->where('warehouse_officer_id', auth()->user()->officer->id);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryNotes::route('/'),
            'edit' => Pages\EditDeliveryNote::route('/{record}/edit'),
            'view' => Pages\ViewDeliveryNote::route('/{record}/view'),
        ];
    }
}
