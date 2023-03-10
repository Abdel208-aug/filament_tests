<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Squire\Models\Country;

class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function account():BelongsTo
    {
        return $this->belongsTo(
            related: Account::class,
            foreignKey:'account_id',
        );
    }

    public function contacts():HasMany
    {
        return $this->hasMany(
            related: Contact::class,
            foreignKey:'organization_id'
        );
    }

    public function scopeAccount(Builder $builder) : Builder
    {
        return $builder->whereBelongsTo(auth()->user()->account);
    }

    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? null, function ($query, $search) {
    //         $query->where('name', 'like', '%'.$search.'%');
    //     })->when($filters['trashed'] ?? null, function ($query, $trashed) {
    //         if ($trashed === 'with') {
    //             $query->withTrashed();
    //         } elseif ($trashed === 'only') {
    //             $query->onlyTrashed();
    //         }
    //     });
    // }
}
