<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryNote;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeliveryNoteResource\Pages;

class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Surat Jalan';

    protected static ?string $modelLabel = 'Surat Jalan';

    protected static ?string $slug = 'Surat-Jalan';

    protected static ?string $pluralModelLabel = 'Surat Jalan';

    protected static ?string $recordTitleAttribute = 'nomor_surat';

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
                                    Forms\Components\TextInput::make('nomor_surat')
                                        ->label('Nomor Surat')
                                        ->disabled()
                                        ->dehydrated()
                                        ->helperText('Nomor surat akan digenerate otomatis'),

                                    Forms\Components\Grid::make()
                                        ->schema([
                                            // Untuk Petugas Klien
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
                                                ->required(),

                                            // Untuk Petugas Lapangan
                                            Forms\Components\Select::make('field_officer_id')
                                                ->label('Petugas Lapangan')
                                                ->relationship(
                                                    'fieldOfficer',
                                                    'employee_id',
                                                    fn(Builder $query) => $query
                                                        ->where('type', 'field')
                                                        ->where('is_active', true)
                                                        ->with('user')
                                                )
                                                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->user->name} ({$record->employee_id})")
                                                ->searchable() // Hanya searchable tanpa parameter
                                                ->preload(),

                                            // Untuk Petugas Ruangan
                                            Forms\Components\Select::make('room_officer_id')
                                                ->label('Petugas Ruangan')
                                                ->relationship(
                                                    'roomOfficer',
                                                    'employee_id',
                                                    fn(Builder $query) => $query
                                                        ->where('type', 'room')
                                                        ->where('is_active', true)
                                                        ->with('user')
                                                )
                                                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->user->name} ({$record->employee_id})")
                                                ->searchable()
                                                ->preload(),

                                            // Untuk Petugas Gudang
                                            Forms\Components\Select::make('warehouse_officer_id')
                                                ->label('Petugas Gudang')
                                                ->relationship(
                                                    'warehouseOfficer',
                                                    'employee_id',
                                                    fn(Builder $query) => $query
                                                        ->where('type', 'warehouse')
                                                        ->where('is_active', true)
                                                        ->with('user')
                                                )
                                                ->getOptionLabelFromRecordUsing(fn($record) => "{$record->user->name} ({$record->employee_id})")
                                                ->searchable()
                                                ->preload(),
                                        ])
                                        ->columns(2)
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
                                            Forms\Components\DateTimePicker::make('tanggal_pengiriman')
                                                ->label('Tanggal dan Waktu Pengiriman')
                                                ->default(now())
                                                ->seconds(false)
                                                ->native(false)
                                                ->timezone('Asia/Makassar'),

                                            Forms\Components\Select::make('ship_to')
                                                ->label('Tujuan Pengiriman')
                                                ->options([
                                                    'gudang kota' => 'Gudang Kota',
                                                    'gudang unaaha' => 'Gudang Unaaha',
                                                    'gudang kolaka' => 'Gudang Kolaka',
                                                ])
                                                ->native(false)
                                                ->required(),

                                            Forms\Components\Select::make('palka')
                                                ->label('Palka')
                                                ->options([
                                                    'palka 1' => 'Palka 1',
                                                    'palka 2' => 'Palka 2',
                                                ])
                                                ->native(false)
                                                ->required(),
                                        ])->columns(3),

                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('nomor_plat')
                                                ->label('Nomor Plat')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('nama_driver')
                                                ->label('Nama Driver')
                                                ->required()
                                                ->maxLength(255),
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
                                                            'robek truck' => 'Robek Truck',
                                                            'basah truck' => 'Basah Truck',
                                                            'robek pbm' => 'Robek PBM',
                                                            'basah pbm' => 'Basah PBM',
                                                            'karung lebih' => 'Karung Lebih',
                                                            'karung kurang' => 'Karung Kurang',
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

                    Step::make('Status Pengiriman')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->description('Status dan informasi penerimaan')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\Select::make('status')
                                                ->label('Status')
                                                ->options([
                                                    'dibuat' => 'Dibuat',
                                                    'dikirim' => 'Dikirim',
                                                    'sampai' => 'Sampai',
                                                    'selesai' => 'Selesai',
                                                ])
                                                ->native(false)
                                                ->default('dibuat')
                                                ->required(),

                                            Forms\Components\ToggleButtons::make('print')
                                                ->label('Sudah Dicetak')
                                                ->boolean()
                                                ->inline()
                                                ->default(false),
                                        ])->columns(2),

                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\DateTimePicker::make('tanggal_sampai')
                                                ->label('Tanggal dan Waktu Sampai')
                                                ->required()
                                                ->default(now())
                                                ->seconds(false)
                                                ->native(false)
                                                ->timezone('Asia/Makassar')
                                                ->visible(fn(callable $get) => in_array($get('status'), ['sampai', 'selesai'])),

                                            Forms\Components\DateTimePicker::make('tanggal_bongkar')
                                                ->label('Tanggal dan Waktu Bongkar')
                                                ->required()
                                                ->default(now())
                                                ->seconds(false)
                                                ->native(false)
                                                ->timezone('Asia/Makassar')
                                                ->visible(fn(callable $get) => $get('status') === 'selesai'),
                                        ])->columns(2),
                                ]),
                        ]),
                ])
                    ->skippable()
                    ->persistStepInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->defaultSort('created_at', 'desc')
            ->columns([
                // Informasi Dasar
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

                // Informasi Klien
                Tables\Columns\TextColumn::make('client.user.name')
                    ->label('Nama PIC')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.company_name')
                    ->label('Perusahaan PIC')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Informasi Petugas
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

                // Informasi Pengiriman
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

                // Informasi Item
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

                // Informasi Waktu
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
            ->filters([
                Tables\Filters\SelectFilter::make('ship_to')
                    ->label('Tujuan')
                    ->multiple()
                    ->options([
                        'gudang kota' => 'Gudang Kota',
                        'gudang unaaha' => 'Gudang Unaaha',
                        'gudang kolaka' => 'Gudang Kolaka',
                    ])
                    ->placeholder('Pilih tujuan pengiriman')
                    ->native(false)
                    ->searchable(),

                Tables\Filters\TrashedFilter::make()
                    ->label('Tampilkan Data Terhapus')
                    ->placeholder('Data Terhapus')
                    ->native(false),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal')
                            ->placeholder('Tanggal mulai')
                            ->displayFormat('d M Y')
                            ->native(false)
                            ->closeOnDateSelection(),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal')
                            ->placeholder('Tanggal selesai')
                            ->displayFormat('d M Y')
                            ->native(false)
                            ->closeOnDateSelection(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Dari tanggal ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Sampai tanggal ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->filtersFormColumns(2)

            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil')
                        ->color('success'),

                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                    Tables\Actions\Action::make('print')
                        ->label('Cetak')
                        ->color('info')
                        ->icon('heroicon-o-printer')
                        ->url(fn(DeliveryNote $record) => route('filament.admin.resources.Surat-Jalan.print', $record)),

                    Tables\Actions\ForceDeleteAction::make()
                        ->label('Hapus Permanen')
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                    Tables\Actions\RestoreAction::make()
                        ->label('Pulihkan')
                        ->color('warning')
                        ->icon('heroicon-o-arrow-path'),
                ])
                    ->button()
                    ->color('primary')
                    ->label('Tindakan')
                    ->size(ActionSize::Small),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Yang Dipilih')
                        ->color('danger')
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('Hapus Permanen Yang Dipilih')
                        ->color('danger')
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->label('Pulihkan Yang Dipilih')
                        ->color('warning')
                        ->icon('heroicon-o-arrow-path'),
                ])
                    ->button()
                    ->color('primary')
                    ->label('Tindakan')
                    ->size(ActionSize::Medium),
            ])
            ->emptyStateHeading('Belum ada surat jalan')
            ->emptyStateDescription('Buat surat jalan baru dengan klik tombol buat di Bawah ini')
            ->emptyStateIcon('heroicon-o-document-text')
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Surat Jalan')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function query(): Builder
    {
        return parent::query()->with([
            'client.user',
            'fieldOfficer.user',
            'roomOfficer.user',
            'warehouseOfficer.user',
        ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryNotes::route('/'),
            'create' => Pages\CreateDeliveryNote::route('/create'),
            'edit' => Pages\EditDeliveryNote::route('/{record}/edit'),
            'print' => Pages\PrintDeliveryNote::route('/{record}/print'),
            'laporan' => Pages\LaporanSuratJalan::route('/laporan'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()
            ->where('status', 'selesai')
            ->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah surat jalan yang sudah selesai';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
