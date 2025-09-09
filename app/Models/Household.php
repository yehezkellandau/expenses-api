<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'join_code',
    ];

    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($household) {
            // Auto-generate a unique join_code if not provided
            $household->join_code = $household->join_code ?? Str::uuid();
        });
    }
}
