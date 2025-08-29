<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id','id');
    }

    public function getHierarchyStringAttribute(): string
    {
        $hierarchy = [];
        $category = $this->parent;



        // Traverse the hierarchy without additional queries
        while ($category) {
            $hierarchy[] = $category->name;
            $category = $category->parent; // Uses Eloquent's cached relationship
        }

        return implode(' ----> ', array_reverse($hierarchy));
    }
}
