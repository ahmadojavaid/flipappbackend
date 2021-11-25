<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Http\Models\VerificationCode;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use App\Http\Models\UserDeliveryAddress;
use App\Http\Models\UserPaymentMethodDetail;
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens,EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','braintree_id', 'paypal_email',
        'card_brand','card_last_four','trial_ends_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    public function verificationCode(){
        return $this->hasMany(VerificationCode::class);
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function deliveryAddress(){
        return $this->hasOne(UserDeliveryAddress::class,'user_id','id');
    }
    public function paymentPaypal($type = ''){
        return $this->hasOne(UserPaymentMethodDetail::class,'user_id','id')
                ->where(['type' => 'paypal','status' => 'active']);
    }
    public function paymentCreditCard($type = ''){
        return $this->hasOne(UserPaymentMethodDetail::class,'user_id','id')
                ->where(['type' => 'credit_card','status' => 'active']);
    }
    public function verifiedPaymentMethod(){
        return $this->hasMany(UserPaymentMethodDetail::class,'user_id','id')
                ->where(['status' => 'active']);
    }
}
