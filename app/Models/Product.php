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
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     // Automatically generate a unique code when creating an order
    //     static::creating(function ($model) {
    //         $model->barcode = $model->generateUniqueCode(12);
    //     });
    // }

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



  public function scopeSearch($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') return $query;

        return $query->where('code', 'like', "%{$term}%");
    }


}
