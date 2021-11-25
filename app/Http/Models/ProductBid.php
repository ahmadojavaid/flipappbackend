<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class ProductBid extends Model
{
    protected $guarded = [];

    public function getAllBids($userID)
    {
        return self::join('products', 'products.id','=','product_bids.product_id')
            ->join('product_images', 'products.id','=','product_images.product_id')
            ->join('product_sizes', 'product_bids.product_size_id','=','product_sizes.product_id')
            ->select('products.id','product_name','size','bid','image_url','bid_status')
            ->where('product_bids.user_id','=',$userID)
            ->where('product_bids.bid_status','=',0)
            ->groupby('products.id')
            ->get();
    }

    public function tradeHistory($userID)
    {
        return self::join('products', 'products.id','=','product_bids.product_id')
            ->join('product_images', 'products.id','=','product_images.product_id')
            ->join('product_sizes', 'product_bids.product_size_id','=','product_sizes.product_id')
            ->select('products.id','product_name','size','bid','image_url','bid_status')
            ->where('product_bids.user_id','=',$userID)
            ->groupby('products.id')
            ->get();
    }
    public function productSize(){
        return $this->belongsTo(ProductSize::class,'product_size_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function couponBid(){
        return $this->hasOne(CouponUser::class,'object_id','id')->where('object_type','bids');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')->where('product_status',1);
    }
    public function getHighestBid($p_id,$p_s_id){
        return $this->where('product_id',$p_id)->where('product_size_id',$p_s_id)->where('bid_status','active')->max('bid');
    }
    public function getLowestBid($p_id,$p_s_id){
        return $this->where('product_id',$p_id)->where('product_size_id',$p_s_id)->where('bid_status','active')->min('bid');
    }
    public function getLowestAsk($p_id,$p_s_id){
        return ProductAsk::where('product_id',$p_id)->where('product_size_id',$p_s_id)->where('ask_status','active')->min('ask');
    }
}
