<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount', 'discount_type', 'expiry_date', 'usage_limit', 'used_count',
    ];

    protected $casts = [
        'expiry_date' => 'datetime', // Cast expiry_date to Carbon instance
    ];

    public function isValid()
    {
        return ($this->expiry_date === null || $this->expiry_date->isFuture()) &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }
}
