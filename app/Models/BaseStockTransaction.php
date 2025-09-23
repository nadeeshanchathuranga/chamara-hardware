<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseStockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'base_stock_id',
        'paint_order_id',
        'transaction_type',
        'quantity_before',
        'quantity_after', 
        'quantity_changed',
        'notes',
        'performed_by',
    ];

    protected $casts = [
        'quantity_before' => 'decimal:2',
        'quantity_after' => 'decimal:2',
        'quantity_changed' => 'decimal:2',
    ];

    public function baseStock()
    {
        return $this->belongsTo(BaseStock::class);
    }

    public function paintOrder()
    {
        return $this->belongsTo(PaintOrder::class);
    }

    // Helper methods
    public function getTransactionTypeColorAttribute()
    {
        return match($this->transaction_type) {
            'reduction' => 'text-red-600',
            'addition' => 'text-green-600',
            'adjustment' => 'text-blue-600',
            default => 'text-gray-600'
        };
    }

    public function getTransactionTypeIconAttribute()
    {
        return match($this->transaction_type) {
            'reduction' => '↓',
            'addition' => '↑',
            'adjustment' => '~',
            default => '-'
        };
    }
}
