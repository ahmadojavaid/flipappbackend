<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\Product; 
use App\Http\Models\ProductAsk;
use App\Http\Models\ProductSize;
use App\Http\Models\Setting;
use Carbon\Carbon;
use Auth;
class AskController extends ApiController
{
	/*** Portfolio section method that involves in asks **/
    public function searchProduct(Request $request){
    	$validator = Validator::make($request->all(), [
                        'search'  => 'required',
                    ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	$search = request()->search;
		$products = Product::where('product_name','like','%'.$search.'%')
						->where('product_status',1)
                        ->limit(15)
						->with('productImage','ProductSizes.productTypeSize')
						->get();
    	$arr = [
			'products' => $products,
        ];
        if(count($arr['products']) > 0){
        	$this->apiHelper->statusCode     = 1;
	        $this->apiHelper->statusMessage  = 'Product fetched successfully!';
	        $this->apiHelper->result         = $arr;
	        return response()->json($this->apiHelper->responseParse(),200);	
        }else{
        	$this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = 'No Product Found';
	        // $this->apiHelper->result         = $arr;
	        return response()->json($this->apiHelper->responseParse(),200);
        } 
    }

    public function savProductPortfolio(Request $request){
    	$validator = Validator::make($request->all(), [
            'condition' 	=>  'required',
            // 'size' 			=>  'required',
            'price' 		=>  'required', 
            'day' 			=>  'required', 
            'month' 		=>  'required',
            'year'			=>	'required',
            'product_id'	=>	'required',
            'size_id'		=>	'required'
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	$date = request()->year.'-'.request()->month.'-'.request()->day;
    	$productAsk = ProductAsk::where('product_id',request()->product_id)
                              ->where('product_size_id',request()->size_id)
                              ->where('seller_id',Auth::user()->id)
                              ->where('condition',request()->condition)
                              ->where('ask_status','portfolio')
                              ->first();
        $productAskActive = ProductAsk::where('product_id',request()->product_id)
                              ->where('product_size_id',request()->size_id)
                              ->where('seller_id',Auth::user()->id)
                              ->where('condition',request()->condition)
                              ->where('ask_status','active')
                              ->first();
        $product = Product::where('id',request()->product_id)
        					->where('product_status',1)
        					->first();
        $product_size = ProductSize::where('id',request()->size_id)
        							->where('status','active')
        							->first();
        if($product){
		    if($productAsk || $productAskActive){
		        $this->apiHelper->statusCode     = 0;
		        $this->apiHelper->statusMessage  = 'Error, You can\'t add a product in Portfolio. Product already added.';
		        return response()->json($this->apiHelper->responseParse(),422);
		    }
		    $arr = [
		    	'portfolio' 	=> $request->all(),
		    	'product'		=> $product,
		    	'productSize'	=> $product_size
		    ];
	    	$this->apiHelper->statusCode     = 1;
	        $this->apiHelper->statusMessage  = '';
	        $this->apiHelper->result  		 = $arr;
	        return response()->json($this->apiHelper->responseParse(),200);
    	}else{
    		$this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = 'Product Id is wrong.';
	        return response()->json($this->apiHelper->responseParse(),422);
    	}	
    }
    public function getDetailPlaceAsk(Request $request){
    	$validator = Validator::make($request->all(), [
            'product_id'	=>	'required', 
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $setting = Setting::where('key','paypal_fee')->first();
        	$shipment_fee = Setting::where('key','shipment_fee')->first();
        	$product = Product::where('id',request()->product_id)
        						->where('product_status',1)
        						->first();
        	$arr = [
        		'paypalFee' 	=>	$setting,
        		'shippingFee'	=>	$shipment_fee,
        		'product'		=>	$product
        	];
        	$this->apiHelper->statusCode     = 1;
	        $this->apiHelper->statusMessage  = 'Detail Fetched Successfully';
	        $this->apiHelper->result 		 = $arr;
	        return response()->json($this->apiHelper->responseParse(),200);
        }else{
            $this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = 'Error!, Please Add the at least one payment method.';
	        return response()->json($this->apiHelper->responseParse(),422);
        }
    }
    public function savePlaceAsk(Request $request){
        $validator = Validator::make($request->all(), [
            'ask' 				=>	'required',
            'term_condition' 	=>	'required',
            'expiry_day' 		=>	'required',
            'product_id'		=>	'required',
            'product_size_id'	=>	'required',
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
		$setting = Setting::where('key','paypal_fee')->first();
    	$product_id = request()->product_id;
    	$product_size_id = request()->product_size_id;
    	$ask = request()->ask;
        $condition = 'new';
    	$expiry_date = Carbon::now()->addDays(request()->expiry_day);
    	$expiry_date = $expiry_date->toDateString();
        $productAsk = ProductAsk::where('product_id',$product_id)
                                  ->where('product_size_id',$product_size_id)
                                  ->where('seller_id',Auth::user()->id)
                                  ->where('condition',$condition)
                                  ->where('ask_status','active')
                                  ->first();
        if($productAsk){
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Error, You can\'t place a Ak. Your Ask already placed.';
            return response()->json($this->apiHelper->responseParse(),422);
        }

        $transaction_fee = 0;
        $total			 = 0;
    	if($setting->value > 0){
    		$transaction_fee = ((float)$setting->value/100)*$ask;
    		$total = (float)$ask - (float)$transaction_fee;
    	}else{
    		$total = $ask;
    	}
    	$product_ask = new ProductAsk();
		$product_ask->product_id = $product_id;
    	$product_ask->product_size_id = $product_size_id;
        $product_ask->ask = $ask;
    	$product_ask->condition = $condition;
    	$product_ask->transaction_fee = $transaction_fee;
        $product_ask->expires_at = $expiry_date;
    	$product_ask->seller_id = Auth::user()->id;
    	$product_ask->ask_status = 'active';
    	$product_ask->total = $total;
    	$is_saved = $product_ask->save();
    	if($is_saved){
    		$arr = [
    			'productAsk' => $product_ask,
    			'setting'	 => $setting
    		];
    		$this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Ask Placed Successfully.';
            $this->apiHelper->result 		 = $arr;
            return response()->json($this->apiHelper->responseParse(),200);
    	}else{
    		$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Something went wrong.';
            return response()->json($this->apiHelper->responseParse(),422); 
    	}
    }
    public function getUserAsk(){
    	$productAsks = ProductAsk::where('seller_id',Auth::user()->id)
    								->where('ask_status','!=','buy')
    								->with('product.singleLowestAsk','productSize.productTypeSize','product.productImage')
    								->orderBy('product_asks.created_at','desc')
    								->get();
    	$arr = [
    		'productAsks'	=> $productAsks,
    	];
    	$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'All Seller Asks Fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    public function editAskSave(Request $request){
        $setting = Setting::where('key','paypal_fee')->first();
        $validator = Validator::make($request->all(), [
            'ask'               =>  'required',
            // 'term_condition'    =>  'required',
            'product_id'        =>  'required',
            'product_size_id'   =>  'required',
            'ask_id'            =>  'required',
        ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $product_id = request()->product_id;
        $product_size_id = request()->product_size_id;
        $product_ask_id = request()->ask_id;
        $ask = request()->ask;
        if(!empty(request()->expiry_day)){
            $expiry_date = Carbon::now()->addDays(request()->expiry_day);
            $expiry_date = $expiry_date->toDateString();
        }
        

        if($setting->value > 0){
            $transaction_fee = ((float)$setting->value/100)*$ask;
            $total = (float)$ask - (float)$transaction_fee;
        }else{
            $total = $ask;
        }
        $product_ask = ProductAsk::where('id',$product_ask_id)->first();
        if($product_ask){
            $product_ask->product_id = $product_id;
            $product_ask->product_size_id = $product_size_id;
            $product_ask->ask = $ask;
            $product_ask->transaction_fee = $transaction_fee;
            if(!empty(request()->expiry_day)){
               $product_ask->expires_at = $expiry_date; 
            }
            $product_ask->seller_id = Auth::user()->id;
            $product_ask->ask_status = 'active';
            $product_ask->total = $total;
            $is_saved = $product_ask->save();
            if($is_saved){
                $arr = [
                    'ask' => $product_ask
                ];
                $this->apiHelper->statusCode     = 1;
                $this->apiHelper->statusMessage  = 'Ask Update Successfully';
                $this->apiHelper->result         = $arr;
                return response()->json($this->apiHelper->responseParse(),200);
            }else{
                $this->apiHelper->statusCode     = 0;
                $this->apiHelper->statusMessage  = 'Something went wrong';
                return response()->json($this->apiHelper->responseParse(),422);
            }
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Ask not found.';
            return response()->json($this->apiHelper->responseParse(),422);
        }
    }

    /**  End Portfolio ***/

    public function getPlaceAskDetails(Request $request){
    	$validator = Validator::make($request->all(), [
            'product_id'	=>	'required', 
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $setting = Setting::where('key','paypal_fee')->first();
        	$shipment_fee = Setting::where('key','shipment_fee')->first();
        	$product = Product::where('id',request()->product_id)
        						->with('ProductSizes.productTypeSize')
        						->where('product_status',1)
        						->first();
        	$arr = [
        		'paypalFee' 	=>	$setting,
        		'shippingFee'	=>	$shipment_fee,
        		'product'		=>	$product
        	];
        	$this->apiHelper->statusCode     = 1;
	        $this->apiHelper->statusMessage  = 'Detail Fetched Successfully';
	        $this->apiHelper->result 		 = $arr;
	        return response()->json($this->apiHelper->responseParse(),200);
        }else{
            $this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = 'Error!, Please Add the at least one payment method.';
	        return response()->json($this->apiHelper->responseParse(),422);
        }
    }


    public function getDataBySize(Request $request){
    	$validator = Validator::make($request->all(), [
            'product_id'		=>	'required',
            'size_id'			=>	'required'
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
        $min_product_ask = ProductAsk::where('product_id',$product_id)
        							->where('ask_status','active')
        							->where('product_size_id',$size_id)
        							->min('ask');
        $max_product_ask = ProductAsk::where('product_id',$product_id)
        							->where('ask_status','active')
        							->where('product_size_id',$size_id)
        							->max('ask');
        $is_exist = ProductAsk::where('product_id',$product_id)
                                ->where('product_size_id',$size_id)
                                ->where('condition',session('condition'))
                                ->where(function($q){
                                    $q->where('ask_status','active')
                                      ->orWhere('ask_status','inactive');
                                })
                                ->where('seller_id',Auth::user()->id)
                                ->first();
        if($is_exist){
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Error, You can\'t place a ASk. Because your ask already placed';
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $arr = [
            'min_ask' => $min_product_ask,
            'max_ask' => $max_product_ask
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Detail Fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }

    public function getLowestAsk(){
        // dd(request()->all());
        $lowestAsk = ProductAsk::when(!empty(request()->product_id),function($qry){
                $qry->where('product_id',request()->product_id);
            })->when(!empty(request()->product_size_id),function($qry){
                $qry->where('product_size_id',request()->product_size_id);
            })
            ->when((!empty(request()->product_size_id) && !empty(request()->product_id)),function($qry){
                $qry->where('product_id',request()->product_id)
                    ->where('product_size_id',request()->product_size_id);
            })->where('ask_status','active')
                ->orderBy('ask','asc')
                ->paginate(config('constants.paginate_per_page'));

        $arr = [
            'lowestAsk' => $lowestAsk
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'All Lowest Asks Fetched Successfully';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200); 

    }
}
