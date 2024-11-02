<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Officer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OfficerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfficerResource extends Resource
{
    protected static ?string $model = Officer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Petugas';

    protected static ?string $modelLabel = 'Petugas';

    protected static ?string $slug = 'Petugas';

    protected static ?string $pluralModelLabel = 'Petugas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->description('Pilih atau buat pengguna baru untuk Petugas ini')
                    ->schema([
                        Forms\Components\TextInput::make('employee_id')
                            ->label('ID Karyawan')
                            ->maxLength(50)
                            ->placeholder('Akan di-generate otomatis')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Select::make('user_id')
                            ->options(function () {
                                return User::where('role', 'officer')
                                    ->whereDoesntHave('officer')
                                    ->pluck('name', 'id');
                            })
                            ->getSearchResultsUsing(function (string $query) {
                                return User::where('role', 'officer')
                                    ->whereDoesntHave('officer')
                                    ->where('name', 'like', "%{$query}%")
                                    ->pluck('name', 'id');
                            })
                            ->getOptionLabelUsing(function ($value) {
                                return User::find($value)?->name;
                            })
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\Wizard::make([
                                    Forms\Components\Wizard\Step::make('Informasi Dasar')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('name')
                                                ->required()
                                                ->label('Nama')
                                                ->maxLength(255)
                                                ->placeholder('Masukkan nama pengguna')
                                                ->columnSpanFull(),

                                            Forms\Components\TextInput::make('phone_number')
                                                ->required()
                                                ->label('Nomor Telepon')
                                                ->maxLength(20)
                                                ->placeholder('Masukkan nomor telepon pengguna')
                                                ->tel(),

                                            Forms\Components\Select::make('role')
                                                ->options([
                                                    'officer' => 'Petugas',
                                                ])
                                                ->required()
                                                ->label('Peran Pengguna')
                                                ->placeholder('Pilih peran pengguna')
                                                ->native(false),
                                        ]),

                                    Forms\Components\Wizard\Step::make('Akun Pengguna')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('email')
                                                ->email()
                                                ->required()
                                                ->label('Email')
                                                ->unique(User::class, 'email', ignoreRecord: true)
                                                ->placeholder('Masukkan email pengguna')
                                                ->columnSpanFull(),

                                            Forms\Components\TextInput::make('password')
                                                ->password()
                                                ->label('Password')
                                                ->minLength(8)
                                                ->revealable()
                                                ->placeholder('Masukkan password pengguna')
                                                ->required(fn($record) => $record === null)
                                                ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                                                ->dehydrated(fn($state) => filled($state)),

                                            Forms\Components\TextInput::make('password_confirmation')
                                                ->password()
                                                ->label('Konfirmasi Password')
                                                ->revealable()
                                                ->same('password')
                                                ->placeholder('Masukkan ulang password pengguna')
                                                ->required(fn($record) => $record === null)
                                                ->dehydrated(false),
                                        ]),

                                    Forms\Components\Wizard\Step::make('Detail Tambahan')
                                        ->columns(2)
                                        ->schema([
                                            Forms\Components\Textarea::make('address')
                                                ->required()
                                                ->rows(10)
                                                ->cols(20)
                                                ->autosize()
                                                ->label('Alamat')
                                                ->maxLength(255)
                                                ->placeholder('Masukkan alamat pengguna'),

                                            Forms\Components\FileUpload::make('avatar_url')
                                                ->label('Foto Profil')
                                                ->image()
                                                ->directory('avatars')
                                                ->nullable(),
                                        ]),
                                ])
                            ])
                            ->createOptionUsing(function (array $data) {
                                $user = User::create([
                                    'name' => $data['name'],
                                    'phone_number' => $data['phone_number'],
                                    'role' => 'officer',
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                    'address' => $data['address'] ?? null,
                                    'avatar_url' => $data['avatar_url'] ?? null,
                                ]);

                                return $user->id;
                            })
                            ->required()
                            ->label('Pilih Pengguna'),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Detail Petugas')
                    ->description('Masukkan detail tambahan untuk petugas')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'field' => 'Lapangan',
                                'room' => 'Ruangan',
                                'warehouse' => 'Gudang',
                            ])
                            ->required()
                            ->label('Jenis Petugas')
                            ->native(false)
                            ->placeholder('Pilih jenis petugas'),

                        Forms\Components\ToggleButtons::make('is_active')
                            ->label('Status Aktif')
                            ->label('Status Aktif')
                            ->boolean()
                            ->helperText('Nonaktifkan jika Petugas sudah tidak aktif')
                            ->inline()
                            ->default(true),
                    ])
                    ->columnSpan(['lg' => 2]),
            ])
            ->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.'),

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                Tables\Columns\TextColumn::make('employee_id')
                    ->searchable()
                    ->sortable()
                    ->label('ID Karyawan'),

                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->badge()
                    ->label('Jenis Petugas')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'room' => 'Petugas Ruangan',
                            'field' => 'Petugas Lapangan',
                            'warehouse' => 'Petugas Gudang',
                        };
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            'room' => 'info',
                            'field' => 'danger',
                            'warehouse' => 'success',
                        };
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status Aktif')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Tanggal Dibuat'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->label('Tampilkan Data Terhapus')
                    ->native(false)
                    ->placeholder('Semua Data'),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Petugas')
                    ->options([
                        'field' => 'Lapangan',
                        'room' => 'Ruangan',
                        'warehouse' => 'Gudang',
                    ])
                    ->native(false)
                    ->placeholder('Semua Jenis Petugas'),

                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])
                    ->native(false)
                    ->placeholder('Semua Status'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil')
                        ->color('success'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                    Tables\Actions\ForceDeleteAction::make()
                        ->label('Hapus Permanen')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                    Tables\Actions\RestoreAction::make()
                        ->label('Pulihkan')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning'),
                ])
                    ->button()
                    ->color('primary')
                    ->label('Tindakan')
                    ->size(ActionSize::Small),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus yang dipilih')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('Hapus yang dipilih permanen')
                        ->color('danger')
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->label('Pulihkan yang dipilih')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning'),
                ])
                    ->button()
                    ->color('primary')
                    ->label('Tindakan')
                    ->size(ActionSize::Medium),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfficers::route('/'),
            'create' => Pages\CreateOfficer::route('/create'),
            'edit' => Pages\EditOfficer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
