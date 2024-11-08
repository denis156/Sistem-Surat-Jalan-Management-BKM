<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClientResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Klien';

    protected static ?string $modelLabel = 'Klien';

    protected static ?string $slug = 'Klien';

    protected static ?string $pluralModelLabel = 'Klien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->description('Pilih atau buat pengguna baru untuk Klien ini')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->options(function () {
                                return User::where('role', 'client')
                                    ->whereDoesntHave('client')
                                    ->pluck('name', 'id');
                            })
                            ->getSearchResultsUsing(function (string $query) {
                                return User::where('role', 'client')
                                    ->whereDoesntHave('client')
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
                                                    'client' => 'Klien',
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
                                    'role' => 'client',
                                    'email' => $data['email'],
                                    'password' => bcrypt($data['password']),
                                    'address' => $data['address'] ?? null,
                                    'avatar_url' => $data['avatar_url'] ?? null,
                                ]);

                                return $user->id;
                            })
                            ->required()
                            ->label('Pilih Pengguna'),

                        Forms\Components\ToggleButtons::make('is_active')
                            ->label('Status Aktif')
                            ->boolean()
                            ->helperText('Nonaktifkan jika Klien sudah tidak aktif')
                            ->inline()
                            ->default(true),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Informasi Perusahaan')
                    ->description('Masukkan detail perusahaan Klien')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Perusahaan'),

                        Forms\Components\Textarea::make('company_address')
                            ->required()
                            ->maxLength(255)
                            ->autosize()
                            ->label('Alamat Perusahaan')
                            ->columnSpanFull(),
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

                Tables\Columns\TextColumn::make('company_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Perusahaan'),

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama PIC'),

                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->label('Email PIC'),

                Tables\Columns\TextColumn::make('user.phone_number')
                    ->label('Nomor Telepon'),

                Tables\Columns\TextColumn::make('company_address')
                    ->limit(20)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 20) {
                            return null;
                        }
                        return $state;
                    })
                    ->label('Alamat Perusahaan'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif')
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
                    ->native(false)
                    ->label('Tampilkan Data Terhapus'),

                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->native(false)
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])
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
            ])
            ->emptyStateHeading('Belum ada klien')
            ->emptyStateDescription('Buat klien baru dengan klik tombol buat di Bawah ini')
            ->emptyStateIcon('heroicon-o-building-office-2')
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Klien')
                    ->icon('heroicon-o-plus'),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
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
