<?php

namespace App\Filament\Field\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryNote;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Field\Resources\DeliveryNoteResource\Pages;

class DeliveryNoteResource extends Resource
{
    protected static ?string $model = DeliveryNote::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Surat Jalan';

    protected static ?string $modelLabel = 'Surat Jalan';

    protected static ?string $slug = 'Surat-Jalan';

    protected static ?string $pluralModelLabel = 'Surat Jalan';

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
                                                ->helperText('Klien surat jalan akan di isi oleh petugas ruangan')
                                                ->disabled(),

                                            Forms\Components\Hidden::make('field_officer_id')
                                                ->default(fn() => auth()->user()->officer->id),
                                        ])
                                        ->columns(2),
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
                                                ->placeholder('Pilih Tujuan Pengiriman')
                                                ->native(false)
                                                ->required(),

                                            Forms\Components\Select::make('palka')
                                                ->label('Palka')
                                                ->options([
                                                    'palka 1' => 'Palka 1',
                                                    'palka 2' => 'Palka 2',
                                                ])
                                                ->placeholder('Pilih Palka')
                                                ->native(false)
                                                ->required(),
                                        ])->columns(2),

                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\TextInput::make('nomor_plat')
                                                ->label('Nomor Plat')
                                                ->required()
                                                ->Placeholder('Masukan Nomor Plat Driver')
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('nama_driver')
                                                ->label('Nama Driver')
                                                ->required()
                                                ->Placeholder('Masukan Nama Driver')
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
                                                        ->placeholder('Masukan Nama Item')
                                                        ->default('Beras 50Kg/Karung')
                                                        ->maxLength(255),

                                                    Forms\Components\TextInput::make('quantity')
                                                        ->label('Jumlah')
                                                        ->numeric()
                                                        ->placeholder('Masukan Jumlah')
                                                        ->required()
                                                        ->minValue(1),

                                                    Forms\Components\Select::make('description')
                                                        ->label('Kondisi')
                                                        ->placeholder('Pilih Kondisi')
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
                    ->columnSpanFull(),
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

            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'dibuat' => 'Dibuat',
                        'dikirim' => 'Dikirim',
                        'sampai' => 'Sampai',
                        'selesai' => 'Selesai',
                    ])
                    ->label('Status')
                    ->native(false),
            ])

            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
                        ->label('Lihat')
                        ->color('secondary')
                        ->icon('heroicon-o-eye')
                        ->url(fn(DeliveryNote $record) => route('filament.field.resources.Surat-Jalan.view', $record)),

                    Tables\Actions\ForceDeleteAction::make()
                        ->label('Hapus Permanen')
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                    Tables\Actions\RestoreAction::make()
                        ->label('Kembalikan')
                        ->color('warning')
                        ->icon('heroicon-o-arrow-path'),

                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil')
                        ->color('success')
                        ->visible(fn(DeliveryNote $record) => $record->status === 'dibuat'),

                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->visible(fn(DeliveryNote $record) => $record->status === 'dibuat'),
                ])
                    ->button()
                    ->color('primary')
                    ->label('Tindakan')
                    ->size(ActionSize::Small),
            ])
            ->emptyStateHeading('Belum ada surat jalan')
            ->emptyStateDescription('Buat surat jalan baru dengan klik tombol buat di Bawah ini')
            ->emptyStateIcon('heroicon-o-document-text')
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        // Menampilkan hanya data yang dibuat oleh field_officer yang login
        return parent::getEloquentQuery()
            ->where('field_officer_id', auth()->user()->officer->id);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryNotes::route('/'),
            'create' => Pages\CreateDeliveryNote::route('/create'),
            'edit' => Pages\EditDeliveryNote::route('/{record}/edit'),
            'view' => Pages\ViewDeliveryNote::route('/{record}/view'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $userId = auth()->user()->officer->id ?? null;

        if ($userId === null) {
            return null;
        }

        return static::getEloquentQuery()
            ->where('field_officer_id', $userId)
            ->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah surat jalan yang kamu buat';
    }
}
