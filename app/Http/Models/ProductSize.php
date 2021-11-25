<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_sizes';

    public function product(){
    	return $this->belongsTo(Product::class,'product_id','id');
    }
    public function productTypeSize(){
    	return $this->belongsTo(ProductTypeSize::class,'product_type_size_id','id');
    }
    public function productAskBySize(){
    	return $this->hasOne(ProductAsk::class,'product_size_id','id')->where('product_id',$this->product_id)->where('ask_status','active');
    }
    public function productAskBySizeMin(){
    	return $this->hasOne(ProductAsk::class,'product_size_id','id');
    }

}
