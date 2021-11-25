<?php

namespace App\Http\Controllers\Web\Homepage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\ProductAsk;
use App\Http\Models\ProductBid;
use App\Http\Models\ProductSale;
use DB;
use Auth;
use Carbon\Carbon;
class ProductController extends Controller
{
    public function allProducts(){
    	// ->whereHas('allLowestAsks',function($qry){
     //    	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
     //    				->groupBy('product_asks.product_id')
     //    				->orderBy('product_asks.ask','asc');
     //    })
    	$products = Product::where('product_status', 1)
                            ->doesnthave('lowestAsk')
                            ->with('productImage')
                            ->orderby('products.created_at','desc')
                            ->paginate(config('constants.paginate_per_page'));
    	$all = 1;

        return view('web.homepage.product.all-products',compact('products','all'));
    }
    public function latestProducts(){
        $products = Product::where('product_status',1)
                            ->whereHas('lowestAsk',function($qry){
                                $qry->groupBy(['product_id','product_size_id']);
                            })
                            ->with('productImage','singleLowestAsk')
                            ->orderBy('created_at','desc')
                            ->paginate(config('constants.paginate_per_page'));
        $all = 7;
        return view('web.homepage.product.all-products',compact('products','all'));
    }
    public function supremeProducts($name){
    	$products = Product::where('product_status',1)->whereHas('brandName',function($qry) use ($name){
    		return $qry->where('brand_name',$name);
    	})->with('ProductSizes','productImage')->orderBy('created_at','desc')->paginate(config('constants.paginate_per_page'));
    	$all = 1;
        return view('web.homepage.product.all-products',compact('products','all'));
    }
    public function lowestAskProduct(){
    	$products = Product::where('product_status',1)->whereHas('allLowestAsks',function($qry){
        	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
                        ->where('ask_status','active')
                        ->groupBy('product_asks.product_id')
        				->orderBy('product_asks.ask','asc');
        })->with('productImage','singleLowestAsk')->paginate(config('constants.paginate_per_page'));

        $all = 2;
        return view('web.homepage.product.all-products',compact('products','all'));
    }
    public function highestBidProduct(){
    	$products = Product::whereHas('allHighestBids',function($qry){
    		return $qry->select([DB::raw('max(product_bids.bid) as ra,bid_status')])
                        ->where('bid_status','active')
                        ->orderBy('ra','desc')
                        ->groupBy('product_bids.product_id');
    	})->with('productImage','singleHighestBid')->groupBy('products.id')->paginate(config('constants.paginate_per_page'));
        $all = 3;
        return view('web.homepage.product.all-products',compact('products','all'));
    }

    public function lowestAskSupremeProduct(){
    	$name = 'supreme';
    	$products = Product::whereHas('brandName',function($qry) use ($name){
            return $qry->where('brand_name',$name);
        })->where('product_status',1)->whereHas('allLowestAsks',function($qry){
        	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
        				->groupBy('product_asks.product_id')
        				->orderBy('product_asks.ask','asc');
        })->with('productImage','singleLowestAsk')->paginate(config('constants.paginate_per_page'));
        $all = 4;
        return view('web.homepage.product.all-products',compact('products','all'));
    }
    public function highestBidSupremeProduct(){
    	$name = 'supreme';
    	$products = Product::whereHas('brandName',function($qry) use ($name){
            return $qry->where('brand_name',$name);
        })->whereHas('allHighestBids',function($qry){
    		return $qry->select([DB::raw('max(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	})->with('productImage')->groupBy('products.id')->paginate(config('constants.paginate_per_page'));
        $all = 5;
        return view('web.homepage.product.all-products',compact('products','all'));
    }

    public function singleProduct($id){

    	$product = Product::where('id',$id)->with('productImages','ProductSizes.productTypeSize')->first();

//    	dd($product);

    	// $ = Product::->with('productImage')->limit(4)->get();


    	// ->whereHas('allLowestAsks',function($qry){
     //    	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
     //    				->groupBy('product_asks.product_id')
     //    				->orderBy('product_asks.ask','asc');
     //    })
    	$related_products = Product::where('id','!=',$product->id)->where('brand_id',$product->brand_id)->where('product_status',1)->with('productImage','singleLowestAsk')->take(3)->get();

    	if(count($related_products) ==  0 || count($related_products) < 0){
    		$related_products = Product::where('id','!=',$product->id)->where('product_status',1)->with('productImage','singleLowestAsk')->take(3)->get();
    	}
    	// dd($related_products);
        session()->forget('condition');
    	return view('web.homepage.product.single-product',compact('product','related_products'));
    }
    public function getDataBySize(){
    	$product_id = request()->product_id;
    	$size_id 	= request()->size_id;
    	if(!empty($product_id) && !empty($size_id)){
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

            if($min_product_ask->ask == 0){
                $min_product_ask = ProductAsk::selectRaw('MIN(product_asks.ask) as ask , product_asks.condition')
                                                ->where('product_id',$product_id)
                                                ->where('product_size_id',$size_id)
                                                ->where('condition','old')
                                                ->where('ask_status','active')
                                                ->first();

//                dd( $min_product_ask);
                $max_product_bid = ProductBid::selectRaw('MAX(product_bids.bid) as max_bid, product_bids.condition')
                                                ->where('product_id',$product_id)
                                                ->where('condition','old')
                                                ->where('product_size_id',$size_id)
                                                ->where('bid_status','active')
                                                ->first();
                if($max_product_bid->max_bid > 0){}else{
                    $max_product_bid = ProductBid::selectRaw('MAX(product_bids.bid) as max_bid, product_bids.condition')
                                            ->where('product_id',$product_id)
                                            ->where('condition','new')
                                            ->where('product_size_id',$size_id)
                                            ->where('bid_status','active')
                                            ->first();
                }
            }

            $count_product_ask_old = ProductAsk::where('product_id',$product_id)
                                                ->where('ask_status','active')
                                                ->where('product_size_id',$size_id)
                                                ->where('condition','old')
                                                ->count();
            $count_product_ask_new = ProductAsk::where('product_id',$product_id)
                                                ->where('ask_status','active')
                                                ->where('product_size_id',$size_id)
                                                ->where('condition','new')
                                                ->count();
    		$asks = ProductAsk::where('product_id',$product_id)
                                ->where('condition',$min_product_ask->condition)
                                ->where('product_size_id',$size_id)
                                ->where('ask_status','active')
                                ->with('productSize.productTypeSize')
                                ->get();
            if($min_product_ask->ask > 0){
                $bids = ProductBid::where('product_id',$product_id)
                                ->where('condition',$min_product_ask->condition)
                                ->where('product_size_id',$size_id)
                                ->where('bid_status','active')
                                ->with('productSize.productTypeSize')
                                ->get();
            }elseif($max_product_bid){
                $bids = ProductBid::where('product_id',$product_id)
                                ->where('condition',$max_product_bid->condition)
                                ->where('product_size_id',$size_id)
                                ->where('bid_status','active')
                                ->with('productSize.productTypeSize')
                                ->get();
            }
            $previousDate = \Carbon\Carbon::now()->subDays(30);
            $mytime = \Carbon\Carbon::now();
            // dd($mytime->toDateTimeString());
    		// $product_sales = DB::select(DB::raw("select DISTINCT DATE(b.created_at) AS d, (
      //                               SELECT MAX(a.total_amount) AS total
      //                               FROM product_sales AS a
      //                               WHERE b.product_status = 'received' AND b.product_id = 2 AND b.product_size_id = 9 AND b.created_at = a.created_at
      //                               ) AS total
      //                               FROM product_sales AS b
      //                               WHERE b.product_status = 'received' AND b.product_id = 2 AND b.product_size_id = 9 AND created_at BETWEEN '2019-12-09 10:34:41' AND '2020-01-08 10:34:41'"));

            // $product_sales = DB::table('product_sales as b')->selectRaw("DISTINCT DATE(b.created_at) AS d, (
            //                         SELECT MAX(a.total_amount) AS total
            //                         FROM product_sales AS a
            //                         WHERE b.product_status = 'received' AND b.product_id = ".$product_id." AND b.product_size_id = ".$size_id." AND b.created_at = a.created_at
            //                         ) AS total")
            //                     ->where('b.product_status','received')
            //                     ->where('b.product_id',$product_id)
            //                     ->where('b.product_size_id',$size_id)
            //                     ->whereBetween('created_at',[$previousDate,$mytime])
            //                     ->orderBy('created_at','asc')
            //                     ->get();
            $product_sales = DB::table('product_sales')->selectRaw('created_at as d,total_amount as total')
                                ->whereBetween('created_at',[$previousDate,$mytime])
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$size_id)
                                ->orderBy('created_at','asc')
                                ->limit(30)
                                ->get()->toArray();
            // $product_sales_limit = ProductSale::selectRaw('created_at as d,total_amount as total,product_size_id,product_id')
            //                     ->where('product_status','received')
            //                     ->where('product_id',$product_id)
            //                     ->where('product_size_id',$size_id)
            //                     ->with('productSize.productTypeSize')
            //                     ->orderBy('created_at','asc')
            //                     ->limit(request()->limit)
            //                     ->get();
            // dd($product_sales_limit);
            $recent_sale = DB::table('product_sales')->select('total_amount')
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$size_id)
                                ->orderBy('created_at','desc')
                                ->first();


                                    // `FROM product_sales AS b
                                    // WHERE b.product_status = 'received' AND b.product_id = 2 AND b.product_size_id = 9 AND created_at BETWEEN '2019-12-09 10:34:41' AND '2020-01-08 10:34:41'`))->get();
                                        // ->where('b.product_status', 'received')->where('b.product_id' , 2)->where('b.product_size_id', 9)->get();

    		$data = [
    			'status'  => 1,
    			'min_ask' => $min_product_ask,
    			'max_bid' => $max_product_bid,
    			'asks'	  => $asks,
    			'bids'	  => $bids,
                'total_new' => $count_product_ask_new,
                'total_old' => $count_product_ask_old,
                'product_sales' => ['sales' => $product_sales,'start_day' => $previousDate->day,'end_data' => $mytime],
                'recent_sale'   => $recent_sale,
                // 'product_sale_limit' => $product_sales_limit
    		];
            if($min_product_ask->condition){
              request()->session()->put('condition',$min_product_ask->condition);
              request()->session()->save();
            }elseif($max_product_bid->max_bid){
                request()->session()->put('condition',$max_product_bid->condition);
                request()->session()->save();
            }
    		return response()->json($data);
    	}else{
    		$data = [
    			'status' => 0
    		];
    		return response()->json($data);
    	}
    }

    public function getDataByConditionSize(){
        $product_id = request()->product_id;
        $size_id    = request()->size_id;
        if(!empty($product_id) && !empty($size_id)){
            $min_product_ask = ProductAsk::selectRaw('MIN(product_asks.ask) as ask , product_asks.condition')
                                            ->where('product_id',$product_id)
                                            ->where('condition',session('condition'))
                                            ->where('product_size_id',$size_id)
                                            ->where('ask_status','active')
                                            ->first();
            $count_product_ask_old = ProductAsk::where('product_id',$product_id)
                                                ->where('product_size_id',$size_id)
                                                ->where('ask_status','active')
                                                ->where('condition','old')
                                                ->count();
            $count_product_ask_new = ProductAsk::where('product_id',$product_id)
                                                ->where('product_size_id',$size_id)
                                                ->where('ask_status','active')
                                                ->where('condition','new')
                                                ->count();

            $max_product_bid = ProductBid::where('product_id',$product_id)
                                            ->where('condition',session('condition'))
                                            ->where('product_size_id',$size_id)
                                            ->where('bid_status','active')
                                            ->max('bid');
            $asks = ProductAsk::where('product_id',$product_id)
                                ->where('condition',session('condition'))
                                ->where('ask_status','active')
                                ->where('product_size_id',$size_id)
                                ->with('productSize.productTypeSize')
                                ->get();
            $bids = ProductBid::where('product_id',$product_id)
                                ->where('condition',session('condition'))
                                ->where('product_size_id',$size_id)
                                ->where('bid_status','active')
                                ->with('productSize.productTypeSize')
                                ->get();
            $data = [
                'status'  => 1,
                'min_ask' => $min_product_ask,
                'max_bid' => $max_product_bid,
                'asks'    => $asks,
                'bids'    => $bids,
                'total_new' => $count_product_ask_new,
                'total_old' => $count_product_ask_old,
            ];
            request()->session()->put('condition',$min_product_ask->condition);
            request()->session()->save();
            return response()->json($data);
        }else{
            $data = [
                'status' => 0
            ];
            return response()->json($data);
        }
    }


    public function getLowestAskBySize(){
        $product_id = request()->product_id;
        $size_id    = request()->size_id;

        if(!empty($product_id) && !empty($size_id)){
            $min_product_ask = ProductAsk::where('product_id',$product_id)->where('ask_status','active')->where('product_size_id',$size_id)->min('ask');
            $max_product_ask = ProductAsk::where('product_id',$product_id)->where('ask_status','active')->where('product_size_id',$size_id)->max('ask');
            $is_exist = ProductAsk::where('product_id',$product_id)
                                    ->where('product_size_id',$size_id)
                                    ->where('condition',session('condition'))
                                    ->where(function($q){
                                        $q->where('ask_status','active')
                                          ->orWhere('ask_status','inactive');
                                    })
                                    ->where('seller_id',Auth::user()->id)->first();
            if($is_exist){
                $is_exist = 1;
            }else{
                $is_exist = 0;
            }
            $data = [
                'status'  => 1,
                'min_ask' => $min_product_ask,
                'max_ask' => $max_product_ask,
                'is_exist'=> $is_exist
            ];
            return response()->json($data);
        }

    }

    public function getHeighestBidBySize(){
        $product_id = request()->product_id;
        $size_id    = request()->size_id;
        $difference = 0;
        if(!empty($product_id) && !empty($size_id)){
            $product_bid = ProductBid::selectRaw('MIN(bid) as min, MAX(bid) as max')->where('product_id',$product_id)
                                            ->where('condition',session('condition'))
                                            ->where('product_size_id',$size_id)
                                            ->where('bid_status','active')
                                            ->first();
            $product_ask = ProductAsk::selectRaw('MAX(ask) as max,MAX(expires_at) expiry')
                                        ->where('product_id',$product_id)
                                        ->where('product_size_id',$size_id)
                                        ->where('ask_status','active')
                                        ->where('condition',session('condition'))
                                        ->orderby('expires_at','desc')
                                        ->first();
                                        // dd($product_ask->expiry);
            if($product_ask){
                $expiry = date('Y-m-d', strtotime($product_ask->expiry));
                $expiry = new Carbon($expiry);
                $now = Carbon::yesterday();
                $difference = $expiry->diff($now)->days;
                // dd($difference);
            }
            // $max_product_bid = ProductBid::where('product_id',$product_id)
            //                                 ->where('condition',session('condition'))
            //                                 ->where('product_size_id',$size_id)
            //                                 ->where('bid_status','active')
            //                                 ->max('bid');
            $is_exist = ProductBid::where('product_id',$product_id)
                                    ->where('condition',session('condition'))
                                    ->where('product_size_id',$size_id)
                                    ->where(function($qry){
                                        $qry->where('bid_status','active')
                                            ->orWhere('bid_status','inactive');
                                    })
                                    ->where('user_id',Auth::user()->id)
                                    ->first();
            if($is_exist){
                $is_exist = 1;
            }else{
                $is_exist = 0;
            }
            $data = [
                'status'  => 1,
                'min_bid' => $product_bid->min,
                'max_bid' => $product_bid->max,
                'difference' => $difference,
                'is_exist'=> $is_exist
            ];
            return response()->json($data);
        }
    }
    public function setSessionCondition(){
        $condition = request()->condition;
        request()->session()->put('condition',$condition);
        request()->session()->save();
        return response()->json(['status' => 1]);
    }

    public function getMonthGraphData(){

        $product_id = request()->product_id;
        $product_size_id = request()->product_size_id;
        switch (request()->filter) {
            case '1':
                $previousDate = \Carbon\Carbon::now()->subDays(30);
                $mytime = \Carbon\Carbon::now();
                $product_sales = DB::table('product_sales')->selectRaw('created_at as d,total_amount as total')
                                ->whereBetween('created_at',[$previousDate,$mytime])
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$product_size_id)
                                ->orderBy('created_at','asc')
                                ->get()->toArray();
                $data = [
                    'status' => 1,
                    'product_sales' => $product_sales
                ];
                return response()->json($data);
                break;
            case '3':
                $previousDate = \Carbon\Carbon::now()->subDays(90);
                $mytime = \Carbon\Carbon::now();
                $product_sales = DB::table('product_sales')->selectRaw('created_at as d,total_amount as total')
                                ->whereBetween('created_at',[$previousDate,$mytime])
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$product_size_id)
                                ->orderBy('created_at','asc')
                                ->get()->toArray();
                $data = [
                    'status' => 1,
                    'product_sales' => $product_sales
                ];
                return response()->json($data);
                break;
            case '6':
                $previousDate = \Carbon\Carbon::now()->subDays(180);
                $mytime = \Carbon\Carbon::now();
                $product_sales = DB::table('product_sales')->selectRaw('created_at as d,total_amount as total')
                                ->whereBetween('created_at',[$previousDate,$mytime])
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$product_size_id)
                                ->orderBy('created_at','asc')
                                ->get()->toArray();
                $data = [
                    'status' => 1,
                    'product_sales' => $product_sales
                ];
                return response()->json($data);
                break;
            case '12':
                $previousDate = \Carbon\Carbon::now()->subDays(365);
                $mytime = \Carbon\Carbon::now();
                $product_sales = DB::table('product_sales')->selectRaw('created_at as d,total_amount as total')
                                ->whereBetween('created_at',[$previousDate,$mytime])
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$product_size_id)
                                ->orderBy('created_at','asc')
                                ->get()->toArray();
                $data = [
                    'status' => 1,
                    'product_sales' => $product_sales
                ];
                return response()->json($data);
                break;
            case '14':
                // $previousDate = \Carbon\Carbon::now()->subDays(365);
                // $mytime = \Carbon\Carbon::now();
                $product_sales = DB::table('product_sales')->selectRaw('created_at as d,total_amount as total')
                                // ->whereBetween('created_at',[$previousDate,$mytime])
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$product_size_id)
                                ->orderBy('created_at','asc')
                                ->get()->toArray();
                $data = [
                    'status' => 1,
                    'product_sales' => $product_sales
                ];
                return response()->json($data);
                break;

            default:
                # code...
                break;
        }


    }

    public function getSales(){
        $product_id = request()->product_id;
        $size_id    = request()->product_size_id;
        $product_sales_limit = ProductSale::selectRaw('created_at as d,total_amount as total,product_size_id,product_id')
                                ->where('product_status','received')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$size_id)
                                ->with('productSize.productTypeSize')
                                ->orderBy('created_at','desc')
                                ->paginate(config('constants.paginate_per_page'));
        $data = [
                'product_sale_limit' => $product_sales_limit
            ];
            return response()->json($data);
    }
}
