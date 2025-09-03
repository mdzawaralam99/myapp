<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /**
     * The attributes that are mass assignable
     * @var list<string>
     */

    protected $fillable= [
        'name'
    ];

    public function hasRole(array $roles): bool{
        return in_array($this->role, $roles);
    }
}
