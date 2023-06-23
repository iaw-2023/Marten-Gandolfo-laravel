<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model /* Authenticatable */
{
    use HasFactory/* , HasApiTokens */;

    public function orders(): HasMany{
        return $this->hasMany(Order::class, 'client_ID');
    }
}
