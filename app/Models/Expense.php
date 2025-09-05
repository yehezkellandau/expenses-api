<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['category', 'amount', 'type', 'date', 'household_id'];

    public function household()
    {
        //test
        return $this->belongsTo(Household::class);
    }
}
