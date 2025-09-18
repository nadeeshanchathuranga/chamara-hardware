<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColoranceStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'can_size', // e.g., "1L", "500ml"
        'unit',     // warehouse stock quantity
    ];

    protected $casts = [
        'unit' => 'integer',
    ];

    // One colorant can have multiple machine stock records (one per machine, if applicable)
    public function machineStocks()
    {
        return $this->hasMany(MachineStock::class);
    }

    // If you enforce a UNIQUE per colorant in the DB, you can use hasOne as a convenience:
    public function machineStock()
    {
        return $this->hasOne(MachineStock::class);
    }
}
