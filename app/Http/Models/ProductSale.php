<?php



namespace App\Http\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    protected $guarded = [];
    
  

    public function product(){
    	return $this->belongsTo(Product::class,'product_id','id');
    }
    public function productSize(){
    	return $this->belongsTo(ProductSize::class,'product_size_id','id');
    }
    public function paymentMethodDetail(){
    	return $this->belongsTo(UserPaymentMethodDetail::class,'user_payment_method_detail_id','id');
    }
    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id','id');
    }
    public function seller(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
}
