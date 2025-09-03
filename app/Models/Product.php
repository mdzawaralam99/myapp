<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The attributes that are mass assignable
 * @var list<string>
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'photo',
        'description',
        'product_category_id'
    ];
    
}
