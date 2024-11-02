<?php

namespace App\Filament\Field\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryNote;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
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
                                        ])->columns(2),

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
