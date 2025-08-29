<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'alert_level',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
