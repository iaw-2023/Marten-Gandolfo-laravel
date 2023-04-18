<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    #protected $table = 'categories';

    public function products(): HasMany{
        return $this->hasMany(Product::class, 'category_ID');
    }

    protected static function booted(){
        static::deleting(function($category){
            $category->products()->delete();
        });
    }
}
