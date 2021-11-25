<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\BinaryOp\Identical;

class FollowingProduct extends Model
{
    protected $table = 'following_products';

    protected $guarded = ['id'];

    public function getAllFollowingProducts($userID){
        $result = self::with(['productDetails'])
            ->join('product_sizes', 'product_sizes.id','=','following_products.product_size_id')
            ->where('user_id','=',$userID)
            ->orderBy('following_products.created_at','desc')
            ->get();
        return $result;
    }

    public function productDetails()
    {
            return $this->belongsTo(Product::class,"product_id")
                ->join('product_images', 'product_images.product_id','=','products.id');
    }

    public function searchProduct($keyword)
    {
        return Product::join('product_images', 'product_images.product_id','=','products.id')
            ->select('products.id','product_name','image_url')
            ->where('product_name','like',"%{$keyword}%")
            ->groupby('products.id')
            ->get();
    }

    public function previewProduct($id)
    {
        return self::join('products', 'products.id','=','following_products.product_id')
            ->join('product_images', 'product_images.product_id','=','products.id')
            ->join('product_sizes', 'product_sizes.id','=','following_products.product_size_id')
            ->select('products.id','product_name','image_url','size','retail_price')
            ->where('following_products.id','=',$id)
            ->groupby('following_products.id')
            ->get();
    }

    public function lowestAsk($id){
        return self::join('product_asks', 'product_asks.product_id','=','following_products.product_id')
            ->join('product_sizes', 'product_sizes.id','=','following_products.product_size_id')
            ->select('price as lowest_ask')
            ->where('following_products.id',$id)
            ->orderby('price','desc')->first();
    }

    public function lastSale($id){
        return self::join('product_sales', 'product_sales.product_id','=','following_products.product_id')
            ->join('product_sizes', 'product_sizes.id','=','following_products.product_size_id')
            ->select('sale_price')
            ->where('following_products.id',$id)
            ->orderby('sale_price','desc')->first();
    }

    /********* Mohsin  *************/
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function productSize(){
        return $this->belongsTo(ProductSize::class,'product_size_id','id');
    }
}
