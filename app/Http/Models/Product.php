<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

     protected $dates = [
        'publish_date',
    ];
    public function getProductDetails($id)
    {
        $result = self::with(['brandName','productImages','ProductSizes','recentSale','lowestAsk',
            'highestBid','productSales'])
            ->where('products.id','=',$id)
            ->orderBy('products.created_at','desc')
            ->get();
        return $result;
    }

    public function getFollowProdPreview($productID)
    {
        return self::with(['productSizes','productImages'])
            ->select('id','product_name')
            ->where('products.id', '=', $productID)
            ->get();
    }

    public function brandName()
    {
        return $this->belongsTo(Brand::class,"brand_id","id");
    }

    public function ProductSizes()
    {
        return $this->hasMany(ProductSize::class)->where('status','active');
        // return $this->hasMany(ProductSize::class)->where('stock','>',0);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function productImage(){
        return $this->hasOne(ProductImage::class)->orderBy('id','desc');
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class)
            ->join('product_sizes', 'product_sizes.id', '=', 'product_sales.product_size_id')
            ->orderBy('product_sales.created_at', 'desc');
    }

    public function recentSale()
    {
        return $this->hasMany(ProductSale::class)->orderBy('product_sales.created_at', 'desc')->limit('1');
    }

    public function SingleProductSales($id)
    {
        return ProductSale::join('product_sizes', 'product_sizes.id', '=', 'product_sales.product_size_id')
            ->selectRaw("product_sales.created_at as date,size, SUM(price) as price")
            ->where('product_sales.product_id', '=', $id)
            ->orderBy('product_sales.created_at', 'desc')
            ->get();
    }

    public function lowestAsk()
    {
        return $this->hasMany(ProductAsk::class)
            ->orderby('ask','asc')->where('ask_status','active');
    }
    // public function getPopularProduct(){
    //     return $this->hasMany(ProductSale::class)
    //             ->orderby('created_at','desc')
    //             ->where('product_status','recevied');
    // }
    public function singleLowestAsk()
    {
        return $this->hasOne(ProductAsk::class)->orderBy('ask','asc')->where('ask_status','active');
    }

    public function singleHighestBid()
    {
        return $this->hasOne(ProductBid::class)->where('bid_status','active')->orderby('bid','desc');
    }

    public function highestBid()
    {
        return $this->hasMany(ProductBid::class)
            ->orderby('bid','desc')->limit('1');
    }



    public function allAsks($id)
    {
        return ProductAsk::join('product_sizes', 'product_sizes.id', '=', 'product_asks.product_size_id')
            ->selectRaw("size,price,
            (SELECT COUNT(ask) FROM product_asks WHERE product_size_id = product_sizes.id) AS stock")
            ->where('product_asks.product_id', '=', $id)
            ->groupby('product_asks.seller_id')
            ->latest('product_asks.created_at')
            ->get();
    }

    public function allBids($id)
    {
        return ProductBid::join('product_sizes', 'product_sizes.id', '=', 'product_bids.product_size_id')
            ->selectRaw("size,price,
            (SELECT COUNT(bid) FROM product_bids WHERE product_size_id = product_sizes.id) AS stock")
            ->where('product_bids.product_id', '=', $id)
            ->groupby('seller_id','product_size_id')
            ->latest('product_bids.created_at')
            ->get();
    }

    public function relatedProducts($id)
    {
        $productDetails = self::find($id);

        $result = self::with(['productImages', 'lowestAsk', 'highestBid'])
            ->where('brand_id', '=', $productDetails->brand_id)
            ->latest()
            ->get();
        return $result;
    }

    public function allLowestAsks()
    {
        return $this->hasMany(ProductAsk::class)
            ->orderby('ask');
    }

    public function allHighestBids()
    {
        return $this->hasMany(ProductBid::class)
            ->orderby('bid','desc');
    }

    public function calendarProducts()
    {
        return self::with(['productImages'])
            ->where('product_status','=',0)
            ->latest('products.created_at')
            ->get();
    }

}
