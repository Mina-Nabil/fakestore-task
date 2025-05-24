<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'description',
        'category',
        'image',
        'is_updated'
    ];

    //scope to get only updated products
    public function scopeIsUpdated($query)
    {
        return $query->where('is_updated', true);
    }

    //scope to get only not updated products
}
