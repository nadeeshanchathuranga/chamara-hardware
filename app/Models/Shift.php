<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'total_sales',
        'cash_in_drawer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
