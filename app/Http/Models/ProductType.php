<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_types';

    public function productTypeSize(){
    	return $this->hasMany(ProductTypeSize::class,'product_type_id','id');
    }
}
