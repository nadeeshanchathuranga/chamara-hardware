<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'paint_product_id',
        'base_type_id',
        'can_size',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationships
    public function paintProduct()
    {
        return $this->belongsTo(PaintProduct::class);
    }

    public function baseType()
    {
        return $this->belongsTo(BaseType::class);
    }

    public function transactions()
    {
        return $this->hasMany(BaseStockTransaction::class);
    }

    // Helper method to reduce stock and create transaction
    public function reduceStock($quantity, $paintOrderId = null, $notes = null, $performedBy = 'System')
    {
        if ($this->quantity < $quantity) {
            throw new \Exception('Insufficient base stock quantity. Available: ' . $this->quantity . ', Required: ' . $quantity);
        }

        $quantityBefore = $this->quantity;
        $quantityAfter = $quantityBefore - $quantity;

        // Update the base stock
        $this->update(['quantity' => $quantityAfter]);

        // Create transaction record
        BaseStockTransaction::create([
            'base_stock_id' => $this->id,
            'paint_order_id' => $paintOrderId,
            'transaction_type' => 'reduction',
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'quantity_changed' => $quantity,
            'notes' => $notes,
            'performed_by' => $performedBy,
        ]);

        return $this;
    }
}
