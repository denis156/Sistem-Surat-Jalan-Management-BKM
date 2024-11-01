<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $slug = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function getNavigationBadge(): ?string
    {
        return DB::table('sessions')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $activeUsers = DB::table('sessions')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        return $activeUsers < 3 ? 'danger' : 'success';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah pengguna yang sedang aktif';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                                    'admin' => 'Admin',
                                    'client' => 'Klient',
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
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.'),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verifikasi Email')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->state(fn($record): bool => !is_null($record->email_verified_at)),
                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'primary' => 'admin',
                        'warning' => 'client',
                        'info' => 'officer',
                    ])
                    ->label('Peran')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'client' => 'Klien',
                            'officer' => 'Petugas',
                            'admin' => 'Admin',
                            default => $state,
                        };
                    }),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Nomor Telepon'),
                Tables\Columns\TextColumn::make('address')
                    ->limit(20)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        // Periksa apakah panjang teks melebihi 20 karakter
                        if (strlen($state) <= 20) {
                            return null;
                        }
                        return $state;
                    })
                    ->label('Alamat'),
                Tables\Columns\TextColumn::make('login_status')
                    ->label('Status')
                    ->badge()
                    ->color(
                        fn($record) =>
                        str_contains($record->login_status, 'Online') ? 'success' : 'gray'
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->native(false),
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'client' => 'Client',
                        'officer' => 'Officer',
                    ])
                    ->native(false)
                    ->label('Filter Peran'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
                Tables\Actions\RestoreAction::make()->label('Pulihkan')->visible(fn($record) => $record->trashed()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
                    Tables\Actions\ForceDeleteBulkAction::make()->label('Hapus Permanen'),
                    Tables\Actions\RestoreBulkAction::make()->label('Pulihkan'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
