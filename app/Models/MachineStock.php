<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MachineStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'colorance_stock_id',
        'units', // stock units on the machine
    ];

    protected $casts = [
        'colorance_stock_id' => 'integer',
        'units' => 'integer',
    ];

    public function colorance()
    {
        return $this->belongsTo(ColoranceStock::class, 'colorance_stock_id');
    }
}
