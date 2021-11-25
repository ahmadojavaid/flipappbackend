<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\Product;
use App\Http\Models\ProductBid;
use App\Http\Models\ProductAsk;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
class HomeController extends ApiController
{
    public function index(){
    	$justDroppedProducts 	= Product::select('products.*','product_asks.*','products.id')
                                    ->where('product_status', 1)
                                    ->leftJoin('product_asks','product_asks.product_id','!=','products.id')
                                    ->with('productImage')
                                    ->groupBy('products.id')
                                    ->orderby('products.created_at','desc')
                                    ->take(4)
                                    ->get();
        $lastestProducts 		= Product::select('products.*','products.id')
                                    ->where('product_status', 1)
                                    ->whereHas('lowestAsk',function($qry){
                                        $qry->groupBy(['product_id','product_size_id'])->where('ask_status','active');
                                    })
                                    // ->with('productImage','lowestAsk')
                                    ->with('productImage','singleLowestAsk')
                                    ->orderby('products.created_at','desc')
                                    ->take(4) 
                                    ->get();
    	$highestBidProducts 	= Product::where('product_status', 1)
                                    ->whereHas('allHighestBids',function($qry){
		                                  return $qry->select([DB::raw('max(product_bids.bid) as ra')])
                                                 ->orderBy('ra','desc')
                                                 ->where('bid_status','active')
                                                 ->groupBy('product_bids.product_id');
	                                })
                                    ->with('productImage','singleHighestBid')
                                    ->groupBy('products.id')
                                    ->take(4)
                                    ->get();
        $lowestAskProducts 		= Product::where('product_status', 1)
                                    ->whereHas('allLowestAsks',function($qry){
    	                               return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
    				                    ->groupBy('product_asks.product_id')
                                        ->where('ask_status','active');
                                    })
                                    ->orderBy('created_at','desc')
                                    ->with('productImage','singleLowestAsk')
                                    ->take(4)
                                    ->get();
        $calenderProducts 		= Product::where('product_status', 2)
                                    ->with(['productImage'])
                                    ->latest('products.created_at')
                                    ->take(4)
                                    ->get();
        $arr = [
        	'justDroppedProducts' 	=> $justDroppedProducts,
        	'lastestProducts'	  	=> $lastestProducts,
        	'highestBidProducts'	=> $highestBidProducts,
        	'lowestAskProducts'		=> $lowestAskProducts,
        	'calenderProducts'		=> $calenderProducts
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product fetched successfully';
        $this->apiHelper->result  		 = $arr; 
        return response()->json($this->apiHelper->responseParse(),200);
    }
    public function getSupreme(){
        $name = 'supreme';
        $lastestProducts = Product::where('product_status', 1)
                                    ->whereHas('brandName',function($qry){
                                        $qry->where('brand_name','supreme');
                                    })
                                    ->whereHas('lowestAsk',function($qry){
                                        $qry->groupBy(['product_id','product_size_id'])
                                        ->where('ask_status','active');
                                    })
                                    ->with('productImage','singleLowestAsk')
                                    ->orderby('created_at','desc')
                                    ->paginate(config('constants.paginate_per_page'));
        $arr = [
            'supreme' => $lastestProducts
        ];
        if(count($lastestProducts) > 0){
            $this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Supreme Product fetched successfully';
            $this->apiHelper->result         = $arr; 
            return response()->json($this->apiHelper->responseParse(),200);
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'No Supreme Product Found';
            return response()->json($this->apiHelper->responseParse(),200);
        }
        

    }
    public function singleProductDetail($id){
        $product = Product::where('id',$id)
                            ->with('productImages','ProductSizes.productTypeSize')
                            ->first();
        $related_products = Product::where('id','!=',$product->id)
                                    ->where('brand_id',$product->brand_id)
                                    ->where('product_status',1)
                                    ->with('productImage','singleLowestAsk')
                                    ->take(3)
                                    ->get();

        if(count($related_products) ==  0 || count($related_products) < 0){
            $related_products = Product::where('id','!=',$product->id)
                                        ->where('product_status',1)
                                        ->with('productImage','singleLowestAsk')
                                        ->take(3)
                                        ->get();
        }
        $arr = [
            'product'           => $product,
            'relatedProducts'   => $related_products
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product Detail fetched successfully';
        $this->apiHelper->result         = $arr; 
        return response()->json($this->apiHelper->responseParse(),200);
    }
    public function getDataBySize(Request $request){
        $validator = Validator::make($request->all(), [
                        'product_id'    => 'required',
                        'size_id'     => 'required',
                    ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $product_id = request()->product_id;
        $size_id    = request()->size_id;

        $min_product_ask = ProductAsk::selectRaw('MIN(product_asks.ask) as ask , product_asks.condition')
                                        ->where('product_id',$product_id)
                                        ->where('product_size_id',$size_id)
                                        ->where('condition','new')
                                        ->where('ask_status','active')
                                        ->first();
        $max_product_bid = ProductBid::selectRaw('MAX(product_bids.bid) as max_bid, product_bids.condition')
                                        ->where('product_id',$product_id)
                                        ->where('condition','new')
                                        ->where('product_size_id',$size_id)
                                        ->where('bid_status','active')
                                        ->first();
        $asks = ProductAsk::where('product_id',$product_id)
                            ->where('condition','new')
                            ->where('product_size_id',$size_id)
                            ->where('ask_status','active')
                            ->with('productSize.productTypeSize')
                            ->get();

        $bids = ProductBid::where('product_id',$product_id)
                        ->where('condition','new')
                        ->where('product_size_id',$size_id)
                        ->where('bid_status','active')
                        ->with('productSize.productTypeSize')
                        ->get();
        
        $arr = [
            'minAsk' => $min_product_ask,
            'maxBid' => $max_product_bid,
            'asks'    => $asks,
            'bids'    => $bids,
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Detail fetched successfully!';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
        
    }

    public function getallJustDroppedProduct(){
        $product_just_dropped = Product::where('product_status',1)
                                    ->orderBy('created_at','desc')
                                    ->with('productImages')
                                    ->paginate(config('constants.paginate_per_page'));
        $arr =  [
            'justDroppedProducts' => $product_just_dropped
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Just Dropped Product fetched successfully!';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    public function getAllLatestProduct(){
        $product_latest = Product::where('product_status',1)
                                    ->join('product_asks','product_asks.product_id','=','products.id')
                                    ->where('product_asks.ask_status','active')
                                    ->orderBy('products.created_at','desc')
                                    ->with('productImages')
                                    ->paginate(config('constants.paginate_per_page'));
        $arr =  [
            'LatestProducts' => $product_latest
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Latest Product fetched successfully!';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }

    public function getAllRelaeseProduct(){
        $release_product = Product::where('product_status',2)
                                    ->orderBy('products.publish_date','desc')
                                    ->with('productImages')
                                    ->paginate(config('constants.paginate_per_page'));
        $arr =  [
            'ReleaseProducts' => $release_product
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Release Product fetched successfully!';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    // public function getAllSales(){
    //     $release_product = ProductSale::where('product_status',2)
    //                                 ->orderBy('products.publish_date','desc')
    //                                 ->with('productImages')
    //                                 ->paginate(config('constants.paginate_per_page'));
    //     $arr =  [
    //         'ReleaseProducts' => $release_product
    //     ];
    //     $this->apiHelper->statusCode     = 1;
    //     $this->apiHelper->statusMessage  = 'Release Product fetched successfully!';
    //     $this->apiHelper->result         = $arr;
    //     return response()->json($this->apiHelper->responseParse(),200);
    // }
}
