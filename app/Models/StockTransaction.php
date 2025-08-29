<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'transaction_type',
        'quantity',
        'transaction_date',
        'supplier_id',
        'reason',
    ];

     // Relationships
     public function product()
     {
        //  return $this->belongsTo(Product::class, 'product_id','id');
         return $this->belongsTo(Product::class)->withTrashed();
     }

     public function supplier()
     {
        return $this->belongsTo(Supplier::class)->withTrashed();
     }
}
