<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaintOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'paint_product_id',
        'color_card_id',
        'base_type_id',
        'product_name',
        'product_code',
        'can_size',
        'quantity',
        'unit_price',
        'status',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    // Append readable names if you like (optional)
    protected $appends = [
        'customer_name',
        'paint_product_name',
        'color_card_name',
        'base_type_name',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function paintProduct()
    {
        return $this->belongsTo(PaintProduct::class);
    }
    public function colorCard()
    {
        return $this->belongsTo(ColorCard::class);
    }
    public function baseType()
    {
        return $this->belongsTo(BaseType::class);
    }

    // Accessors (work best when relations are eager-loaded)
    public function getCustomerNameAttribute()
    {
        return $this->customer->name ?? null;
    }
    public function getPaintProductNameAttribute()
    {
        return $this->paintProduct->name ?? null;
    }
    public function getColorCardNameAttribute()
    {
        return $this->colorCard->name ?? null;
    }
    public function getBaseTypeNameAttribute()
    {
        return $this->baseType->name ?? null;
    }
}