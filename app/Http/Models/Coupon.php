<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $casts = [
        'coupon_applicable' => 'array',
    ];
    protected $softDelete = true;
}
