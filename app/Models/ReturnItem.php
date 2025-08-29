<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'customer_id',
        'product_id',
        'quantity',
        'reason',
        'unit_price',
        'total_price',
        'return_date',
    ];

    // Relationships
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
