<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    public function coupon(){
    	return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
}
