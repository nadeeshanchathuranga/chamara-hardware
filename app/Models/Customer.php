<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'member_since',
        'loyalty_points',
    ];

       public function paintOrders()
    {
        return $this->hasMany(PaintOrder::class);
    }


}
