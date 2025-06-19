<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Household extends Model
{
    use HasFactory;
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
