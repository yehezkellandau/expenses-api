<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['category', 'amount', 'type', 'date', 'household_id'];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
