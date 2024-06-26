<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public function orderDetails(): HasMany{
        return $this->hasMany(OrderDetail::class, 'order_ID');
    }

    public function client(): BelongsTo{
        return $this->belongsTo(Client::class, 'client_ID');
    }
}
