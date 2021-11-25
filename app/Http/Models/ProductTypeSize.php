<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTypeSize extends Model
{
    protected $table = 'product_type_sizes';

    public function productType(){
    	return $this->belongsTo(ProductType::class,'product_type_id','id');
    }

    public function productSize(){
    	return $this->hasOne(ProductSize::class,'product_type_size_id','id');
    }
}
