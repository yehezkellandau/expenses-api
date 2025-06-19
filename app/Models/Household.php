<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    protected static function booted()
    {
        static::creating(function ($household) {
            $household->code = $household->code ?? Str::uuid();
        });
    }
}
