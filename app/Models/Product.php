<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class, 'category_ID');
    }

    public function orderDetails(): HasMany{
        return $this->hasMany(OrderDetail::class, 'product_ID');
    }
}
