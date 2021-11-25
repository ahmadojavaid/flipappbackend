<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Country;

class UserDeliveryAddress extends Model
{
    protected $table = 'user_delivery_address';

    public function country(){
    	return $this->belongsTo(Country::class,'country_id','id');
    }
}
