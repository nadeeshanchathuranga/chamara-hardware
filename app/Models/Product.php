<?php

namespace App\Models;

use App\Traits\GeneratesUniqueCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory, GeneratesUniqueCode;
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'code',
        'size_id',
        'discount',
        'discounted_price',
        'color_id',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'barcode',
        'image',
        'expire_date',
        'batch_no',
        'total_quantity',
        'purchase_date',
        'unit_id',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     // Automatically generate a unique code when creating an order
    //     static::creating(function ($model) {
    //         $model->barcode = $model->generateUniqueCode(12);
    //     });
    // }

     public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id','id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id','id');
    }


    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id','id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id','id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    protected $casts = [
        'expire_date' => 'date', // Cast expiry_date as a date
    ];

    /**
     * Scope for flexible search that matches keywords in any order
     * Example: "50 elbow" or "elbow 50" will both find "50mm Elbow"
     */
    public function scopeFlexibleSearch($query, $searchTerm)
    {
        if (empty($searchTerm)) {
            return $query;
        }

        $rawQuery = trim($searchTerm);
        $normalized = strtolower(str_replace(' ', '', $rawQuery));
        $keywords = array_filter(preg_split('/\s+/', strtolower($rawQuery)));

        return $query->where(function ($sub) use ($normalized, $rawQuery, $keywords) {
            // 1. Normalized search (spaces removed): "50elbow"
            $sub->whereRaw("REPLACE(LOWER(name), ' ', '') LIKE ?", ["%{$normalized}%"])
                ->orWhereRaw("REPLACE(LOWER(code), ' ', '') LIKE ?", ["%{$normalized}%"])
                ->orWhereRaw("REPLACE(LOWER(barcode), ' ', '') LIKE ?", ["%{$normalized}%"])
                // 2. Full phrase search: "50 elbow"
                ->orWhereRaw("LOWER(name) LIKE ?", ["%" . strtolower($rawQuery) . "%"])
                ->orWhereRaw("LOWER(code) LIKE ?", ["%" . strtolower($rawQuery) . "%"])
                ->orWhereRaw("LOWER(barcode) LIKE ?", ["%" . strtolower($rawQuery) . "%"]);
            
            // 3. All keywords must match (in any order): "elbow" AND "50"
            if (count($keywords) > 1) {
                $sub->orWhere(function ($keywordQuery) use ($keywords) {
                    foreach ($keywords as $word) {
                        $keywordQuery->whereRaw("LOWER(name) LIKE ?", ["%" . $word . "%"]);
                    }
                });
                $sub->orWhere(function ($keywordQuery) use ($keywords) {
                    foreach ($keywords as $word) {
                        $keywordQuery->whereRaw("LOWER(code) LIKE ?", ["%" . $word . "%"]);
                    }
                });
            }
        });
    }
}
