<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'user_id',
        'generated_at',
        'details',
    ];

    // Define the allowed report types
    public const TYPES = [
        'Daily Sales',
        'Inventory', 
        'Customer',
        'Paint Orders'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
