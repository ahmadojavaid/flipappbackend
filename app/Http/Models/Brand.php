<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'brand_name', 'brand_image', 'description'
    ];
    public function products(){
    	return $this->hasMany(Product::class,'brand_id','id');
    }
}
