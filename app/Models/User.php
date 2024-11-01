<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasAvatar ,MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'address',
        'role',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship with the Officer model
     */
    public function officer()
    {
        return $this->hasOne(Officer::class);
    }

    /**
     * Authorize access to specific Filament panels based on the user's role and type
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Grant access to the admin panel for admin users
        if ($panel->getId() === 'admin' && $this->role === 'admin') {
            return true;
        }

        // Grant access to the client panel for client users
        if ($panel->getId() === 'client' && $this->role === 'client') {
            return true;
        }

        // Grant access to the appropriate panel based on the officer's type
        if ($this->role === 'officer' && $this->officer) {
            return match ($this->officer->type) {
                'field' => $panel->getId() === 'field',
                'warehouse' => $panel->getId() === 'warehouse',
                'room' => $panel->getId() === 'room',
                default => false,
            };
        }

        return false;
    }

    /**
     * Get the URL of the user's avatar for Filament.
     *
     * @return string|null The URL of the avatar or null if not set.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    /**
     * Get the user's login status
     *
     * @return string The user's login status with the time elapsed since last activity
     */
    public function getLoginStatusAttribute()
    {
        $session = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('user_id', $this->id)
            ->first();

        if ($session) {
            $lastActivity = Carbon::createFromTimestamp($session->last_activity);
            return 'Online - ' . $lastActivity->diffForHumans();
        }

        return 'Offline';
    }

    /**
     * Get the related client for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
}
