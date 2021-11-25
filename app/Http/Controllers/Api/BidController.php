<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Models\Product; 
use App\Http\Models\ProductBid; 
use App\Http\Models\ProductAsk; 
use App\Http\Models\Coupon; 
use App\Http\Models\CouponUser; 
use Carbon\Carbon;
use App\Http\Models\Setting;


class BidController extends ApiController
{
    public function getDetailPlaceBid(Request $request){
    	$validator = Validator::make($request->all(), [
                        'product_id'  => 'required',
                    ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	if(!empty(Auth::user()->paymentCreditCard)){
        	$product = Product::where('id',request()->product_id)
        						->with('ProductSizes.productTypeSize')
        						->where('product_status',1)
        						->first();
        	$shipment_fee = Setting::where('key','shipment_fee')->first();
        	$arr = [
        		'product'		=>	$product,
        		'shipmentFee'	=>	$shipment_fee
        	];
        	$this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Detail Fetched Successfully';
            $this->apiHelper->result         = $arr;
            return response()->json($this->apiHelper->responseParse(),200);
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Error!, Please Add the credit card (mandatory payment method)';
            // $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    }

    public function getHighestBidBySize(Request $request){
    	$validator = Validator::make($request->all(), [
                    'product_id'  => 'required',
                    'size_id'  	  => 'required',
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
        $difference = 0;
        $product_bid = ProductBid::selectRaw('MIN(bid) as min, MAX(bid) as max')
								->where('product_id',$product_id)
                                ->where('condition','new')
                                ->where('product_size_id',$size_id)
                                ->where('bid_status','active')
                                ->first();
        $product_ask = ProductAsk::selectRaw('MAX(ask) as max,MAX(expires_at) expiry')
                                ->where('product_id',$product_id)
                                ->where('product_size_id',$size_id)
                                ->where('ask_status','active')
                                ->where('condition','new')
                                ->orderby('expires_at','desc')
                                ->first();

        if($product_ask->expiry){
            $expiry = date('Y-m-d', strtotime($product_ask->expiry));
            $expiry = new Carbon($expiry);
            $now = Carbon::yesterday();
            $difference = $expiry->diff($now)->days;
        }
        $is_exist = ProductBid::where('product_id',$product_id)
                            ->where('condition','new')
                            ->where('product_size_id',$size_id)
                            ->where(function($qry){
                                $qry->where('bid_status','active')
                                    ->orWhere('bid_status','inactive');
                            })
                            ->where('user_id',Auth::user()->id)
                            ->first();
        if($is_exist){
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'You Can\'t place a bid, because you have already placed a bid';
            // $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }

        $data = [
            'min_bid' => $product_bid->min,
            'max_bid' => $product_bid->max,
            'difference' => $difference,
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Detail Fetched Successfully';
        $this->apiHelper->result         = $data;
        return response()->json($this->apiHelper->responseParse(),200);
    }

    public function discountApply(Request $request){
    	$validator = Validator::make($request->all(), [
                        'code'  => 'required',
                    ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	$code = request()->code;
		$now = Carbon::now();
		$code_verif = Coupon::where('code',$code)
							->whereDate('expires_at', '>=', $now->toDateString())
							->where('starts_at','<=',$now->toDateString())
							->first();
		if($code_verif){
			$coupon_use = CouponUser::where('user_id',Auth::user()->id)
									->where('coupon_id',$code_verif->id)
									->count();
			if($code_verif->max_uses  > $coupon_use){ 
				$arr = [ 
					'couponDetail' => $code_verif
		 		];
    			$this->apiHelper->statusCode     = 1;
	            $this->apiHelper->statusMessage  = 'Coupon code detail fetched succesfully';
	            $this->apiHelper->result 		 = $arr;
	            return response()->json($this->apiHelper->responseParse(),200);
			}else{
	    		$this->apiHelper->statusCode     = 0;
	            $this->apiHelper->statusMessage  = 'Coupon code you have already used.';
	            return response()->json($this->apiHelper->responseParse(),422);
			}
		}else{
			$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Coupon Code is Incorrect';
            return response()->json($this->apiHelper->responseParse(),422);
		}
    }

    public function savePlaceBid(Request $request){
    	$validator = Validator::make($request->all(), [
            'bid' 				=> 'required',
            'term_condition' 	=> 'required',
            'expiry_day' 		=> 'required',
            'product_id' 		=> 'required',
            'product_size_id' 	=> 'required'
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
    	$bid = request()->bid;
        if(request()->expiry_day != 'today'){
            $expiry_date = Carbon::now()->addDays(request()->expiry_day);
            $expiry_date = $expiry_date->toDateString(); 
        }

    	if(!empty(request()->coupon_code)){
    		$coupon = Coupon::where('code',request()->coupon_code)->first();
    		if($coupon){
    				$coupon_uses_count  =  CouponUser::where('user_id',Auth::user()->id)
    													->where('coupon_id',$coupon->id)
    													->count();
    				if($coupon->max_uses < $coupon_uses_count){
    					$this->apiHelper->statusCode     = 0;
			            $this->apiHelper->statusMessage  = 'You already have used this coupon.';
			            return response()->json($this->apiHelper->responseParse(),422);
    				}

    		}else{
    			$this->apiHelper->statusCode     = 0;
	            $this->apiHelper->statusMessage  = 'Coupon Code is Invalid';
	            return response()->json($this->apiHelper->responseParse(),422);
    		}
    	}
     
 		$productBid = ProductBid::where('product_id',$product_id)
								  ->where('product_size_id',$product_size_id)
								  ->where('user_id',Auth::user()->id)
			                      ->where(function($qry){
			                        $qry->where('bid_status','active')
			                            ->orWhere('bid_status','inactive');
			                      })
			                      ->where('condition','new')
								  ->first();
		if($productBid){
			$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'You can\'t place a bid. Your bid already placed.';
            return response()->json($this->apiHelper->responseParse(),422);
		}
		$transaction_fee = 0;
		if(request()->coupon_code){ 
			$total = $bid - (float)$coupon->discount_amount;
			if($total < 0){
				$total = 0;
			}
		}else{
			$total = $bid;
		}
    	$product_bid 					= new ProductBid();
    	$product_bid->product_id 		= $product_id;
    	$product_bid->product_size_id 	= $product_size_id;
    	$product_bid->bid 				= $bid;
    	$product_bid->transaction_fee 	= $transaction_fee;
        if(request()->expiry_day == 'today'){
            $product_bid->expires_at 	= Carbon::now();
        }else{
            $product_bid->expires_at 	= $expiry_date;
        }
    	$product_bid->user_id 			= Auth::user()->id;
        $product_bid->bid_status 		= 'active';
    	$product_bid->condition 		= 'new';
    	$product_bid->total 			= $total;
    	$is_saved 						= $product_bid->save();
    	if($is_saved){
    		if(!empty(request()->coupon_code)){
    			$couponUses = new CouponUser();
	    		$couponUses->user_id   		= Auth::user()->id;
	    		$couponUses->coupon_id 		= $coupon->id;
	    		$couponUses->object_id 		= $product_bid->id;
	    		$couponUses->object_type 	= 'bids';
	    		$couponUses->save();
    		}
    		$product_bid = ProductBid::where('id',$product_bid->id)
    								->orderBy('created_at','desc')
    								->with('couponBid.coupon')
    								->first();
    		$arr = [
    			'productBidDetail'	=> $product_bid
    		];
        	$this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Bid Placed Successfully';
            $this->apiHelper->result 		 = $arr;
            return response()->json($this->apiHelper->responseParse(),200);
    	}else{
    		$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Something went wrong';
            return response()->json($this->apiHelper->responseParse(),422);
    	}
    }

    public function getallBids(){
    	$productBids = ProductBid::where('user_id',Auth::user()->id)
    							->where('bid_status','!=','buy')
    							->with('product.singleLowestAsk','product.singleHighestBid','couponBid.coupon','product.productImage','productSize.productTypeSize')
    							->orderBy('product_bids.created_at','desc')
    							->get();
    	$arr = [ 
			'productBids' => $productBids
 		];
		$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'All Bids Fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200); 	
    }

    public function allHighestBid(){
        $productBid = ProductBid::when(!empty(request()->product_id),function($qry){
                $qry->where('product_id',request()->product_id);
            })->when(!empty(request()->product_size_id),function($qry){
                $qry->where('product_size_id',request()->product_size_id);
            })
            ->when((!empty(request()->product_size_id) && !empty(request()->product_id)),function($qry){
                $qry->where('product_id',request()->product_id)
                    ->where('product_size_id',request()->product_size_id);
            })->where('bid_status','active')
                ->orderBy('bid','desc')
                ->paginate(config('constants.paginate_per_page'));

        // $productBid = ProductBid::where('bid_status','active')
        //             ->orderBy('bid','desc')
        //             ->paginate(config('constants.paginate_per_page'));
        $arr = [
            'highestBid' => $productBid
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'All Highest Bids Fetched Successfully';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200); 
    }
    
      public function editBidSave(Request $request){
         $setting = Setting::where('key','paypal_fee')->first();
        $validator = Validator::make($request->all(), [
            'bid' => 'required',
             'product_id'       => 'required',
            'product_size_id'   => 'required',
            'bid_id'=>'required'
        ]);

          if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
       
        
        $product_id = request()->product_id;
        $product_size_id = request()->product_size;
        $bid = request()->bid;
        $bid_id = request()->bid_id;
         if(request()->expiry_day != 'today'){
            $expiry_date = Carbon::now()->addDays(request()->expiry_day);
            $expiry_date = $expiry_date->toDateString(); 
        }
         
        

        if(!empty(request()->coupon_code)){
            $coupon = Coupon::where('code',request()->coupon_code)->first();
            if($coupon){
                    $coupon_uses_count  =  CouponUser::where('user_id',Auth::user()->id)->where('coupon_id',$coupon->id)->count();
                    if($coupon->max_uses < $coupon_uses_count){
                        flash('Error, Coupon is Expire')->error();
                        return redirect()->back();
                    }

            }else{
                flash('Error, Coupon Code is Invalid')->error();
                return redirect()->back();
            }
        }
     
        

            $transaction_fee = 0;
            if(request()->coupon_code){ 
                $total = $bid - (float)$coupon->discount_amount;
                if($total < 0){
                    $total = 0;
                }
            }else{
                $total = $bid;
            }
            
        // }
        $product_bid = ProductBid::where('id',$bid_id)->first();
        if($product_bid){
            $product_bid->product_id = $product_id;
            $product_bid->product_size_id = $product_size_id;
            $product_bid->bid = $bid;
            $product_bid->transaction_fee = $transaction_fee;
            if(request()->expiry_day == 'today'){
                $product_bid->expires_at = Carbon::now();
            }else{
                $product_bid->expires_at = $expiry_date;
            }
            // $product_bid->expires_at = $expiry_date;
            $product_bid->user_id = Auth::user()->id;
            $product_bid->bid_status = 'active';
            $product_bid->total = $total;
            $is_saved = $product_bid->save();
            if($is_saved){
                $arr = [
                    'bid' => $product_bid
                ];
                if(!empty(request()->coupon_code)){
                    $coupon_user = CouponUser::where('user_id',Auth::user()->id)->where('object_id',$product_bid->id)->where('object_type','bids')->first();
                    if($coupon_user){
                        $coupon_user->user_id = Auth::user()->id;
                        $coupon_user->coupon_id = $coupon->id;
                        $coupon_user->object_id = $product_bid->id;
                        $coupon_user->object_type = 'bids';
                        $coupon_user->save();
                    }else{
                        $couponUses = new CouponUser();
                        $couponUses->user_id = Auth::user()->id;
                        $couponUses->coupon_id = $coupon->id;
                        $couponUses->object_id = $product_bid->id;
                        $couponUses->object_type = 'bids';
                        $couponUses->save();
                    }
                    
                }
                $this->apiHelper->statusCode     = 1;
                $this->apiHelper->statusMessage  = 'bid Update Successfully';
                $this->apiHelper->result         = $arr;
                return response()->json($this->apiHelper->responseParse(),200);
            }else{
                $this->apiHelper->statusCode     = 0;
                $this->apiHelper->statusMessage  = 'Something went wrong';
                return response()->json($this->apiHelper->responseParse(),422);
            }
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'bid not found.';
            return response()->json($this->apiHelper->responseParse(),422);
        }
        
    }
}
