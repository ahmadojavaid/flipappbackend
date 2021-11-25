<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentMethodDetail extends Model
{
    public function paymentMethod(){
    	return $this->belongsTo(PaymentMethod::class,'payment_id','id');
    }
}
