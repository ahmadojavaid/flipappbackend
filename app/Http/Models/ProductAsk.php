<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ProductAsk extends Model
{
    protected $guarded = [];

    public function getAllAsks($userID)
    {
        return self::join('products', 'products.id','=','product_asks.product_id')
            ->join('product_images', 'products.id','=','product_images.product_id')
            ->join('product_sizes', 'product_asks.product_size_id','=','product_sizes.product_id')
            ->select('products.id','product_name','size','ask','image_url','ask_status')
            ->where('product_asks.seller_id','=',$userID)
            ->where('product_asks.ask_status','=',0)
            ->groupby('products.id')
            ->get();
    }

    public function tradeHistory($userID)
    {
        return self::join('products', 'products.id','=','product_asks.product_id')
            ->join('product_images', 'products.id','=','product_images.product_id')
            ->join('product_sizes', 'product_asks.product_size_id','=','product_sizes.product_id')
            ->select('products.id','product_name','size','ask','image_url','ask_status')
            ->where('product_asks.seller_id','=',$userID)
            ->groupby('products.id')
            ->get();
    }
    public function productSize(){
        return $this->belongsTo(ProductSize::class,'product_size_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'seller_id','id');
    }
    public function getLowestAsk($p_id,$p_s_id,$s_id){
        return $this->where('product_id',$p_id)->where('seller_id',$s_id)->where('product_size_id',$p_s_id)->where('ask_status','active')->min('ask');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')->where('product_status',1);
    }
}
