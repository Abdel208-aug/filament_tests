<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;
    public function users():HasMany
    {
        return $this->hasMany(
            related: User::class,
            foreignKey:'account_id',
        );
    }

    public function organizations():HasMany
    {
        return $this->hasMany(
            related: Organization::class,
            foreignKey:'account_id',
        );
    }

    public function contacts():HasMany
    {
        return $this->hasMany(
            related: Contact::class,
            foreignKey:'account_id',
        );
    }
}
