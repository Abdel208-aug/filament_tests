<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser,HasName//,HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;

    public function account():BelongsTo
    {
        return $this->belongsTo(
            related: Account::class,
            foreignKey:'account_id',
        );
    }


    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function canAccessFilament(): bool
    {
        return true;
    }
    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
