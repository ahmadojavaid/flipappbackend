<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\ProductBid;
use App\Http\Models\ProductAsk;
use App\Http\Models\Setting;
use App\Http\Models\Coupon;
use App\Http\Models\CouponUser;
use Auth;
use Carbon\Carbon;

class BidController extends Controller
{
    public function index($id){
        // if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
        if(!empty(Auth::user()->paymentCreditCard)){

        }
    	$product = Product::where('id',$id)->first();
    	$setting = Setting::where('key','paypal_fee')->first();
    	return view('web.dashboard.bids.index',compact('product','setting'));
        // }else{
            // flash('Error!, Please Add the credit card (mandatory payment method)');
            // return redirect()->route('seller.setting.index');
        // }
    }
    public function storeBid(Request $request){
        // dd(request()->all());
    	$this->validate($request, [
            'bid' => 'required',
            'term_condition' => 'required',
            'expiry_day' => 'required',
        ]);
        if(empty(Auth::user()->paymentCreditCard)){
            flash('Error, Please Add Payment method')->error();
            return redirect()->back();
        }
    	$setting = Setting::where('key','paypal_fee')->first();
    	$product_id = request()->product_id;
    	$product_size_id = request()->product_size;
    	$bid = request()->bid;
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

        $productBid = ""; 
     	if(!empty($product_id) && !empty($product_size_id)){
     		$productBid = ProductBid::where('product_id',$product_id)
 									  ->where('product_size_id',$product_size_id)
 									  ->where('user_id',Auth::user()->id)
                                      ->where(function($qry){
                                        $qry->where('bid_status','active')
                                            ->orWhere('bid_status','inactive');
                                      })
                                      ->where('condition',session('condition'))
 									  ->first();
 			if($productBid){
 				flash("Error, You can't place a bid. Your bid already placed.")->error();
    			return redirect()->back();
 			}
     	}else{
            flash("Error, Something went wrong")->error();
            return redirect()->back();
        }


        // if(!empty($product_id) && !empty($product_size_id)){
        //     $productBidd = ProductBid::where('product_id',$product_id)
        //                               ->where('product_size_id',$product_size_id)
        //                               ->where('user_id',Auth::user()->id)
        //                               ->where(function($qry){
        //                                 $qry->where('bid_status','active')
        //                                     ->orWhere('bid_status','inactive');
        //                               })
        //                               ->where('user_id',Auth::user()->id)
        //                               ->where('condition','new')
        //                               ->first();
        //     if($productBidd){
        //         flash("Error, You can't place bid in your own ask.")->error();
        //         return redirect()->back();
        //     }
        // }else{
        //     flash("Error, Something went wrong")->error();
        //     return redirect()->back();
        // }



    	// if($setting->value > 0){
    	// 	$transaction_fee = ((float)$setting->value/100)*$bid;
    	// 	if(request()->coupon_code){ 
    	// 		$total = (float)$bid + (float)$transaction_fee - (float)$coupon->discount_amount;
    	// 		if($total < 0){
    	// 			$total = 0;
    	// 		}
    	// 	}else{
    	// 		$total = (float)$bid + (float)$transaction_fee;
    	// 	}
    	// }else{
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
    	$product_bid = new ProductBid();
    	$product_bid->product_id = $product_id;
    	$product_bid->product_size_id = $product_size_id;
    	$product_bid->bid = $bid;
    	$product_bid->transaction_fee = $transaction_fee;
        if(request()->expiry_day == 'today'){
            $product_bid->expires_at = Carbon::now();
        }else{
            $product_bid->expires_at = $expiry_date;
        }
    	$product_bid->user_id = Auth::user()->id;
        $product_bid->bid_status = 'active';
    	$product_bid->condition = session('condition');
    	$product_bid->total = $total;
    	$is_saved = $product_bid->save();
    	if($is_saved){
    		if(!empty(request()->coupon_code)){
    			$couponUses = new CouponUser();
	    		$couponUses->user_id = Auth::user()->id;
	    		$couponUses->coupon_id = $coupon->id;
	    		$couponUses->object_id = $product_bid->id;
	    		$couponUses->object_type = 'bids';
	    		$couponUses->save();
    		}
            session()->forget('condition');
        	//flash('Success, Record Saved Successfully.')->success();
        	return redirect()->route('seller.bid.thankyou',$product_bid->id);
    	}else{
    		flash('Error, Something went wrong')->error();
    		return redirect()->back();
    	}
    }
    public function codeVerification(){

    	$code = request()->code;
    	if(!empty($code)){
    		$now = Carbon::now();
    		$code_verif = Coupon::where('code',$code)->whereDate('expires_at', '>=', $now->toDateString())->where('starts_at','<=',$now->toDateString())->first();
    		if($code_verif){
    			$coupon_use = CouponUser::where('user_id',Auth::user()->id)->where('coupon_id',$code_verif->id)->count();
    			 // dd($coupon_use);
    			if($code_verif->max_uses  > $coupon_use){ 
    					$arr = [ 
    						'status' => 1,
    						'amount' => $code_verif->discount_amount,
    						'code'   => $code_verif->code,
    						 
	    		 		];
	    				return response()->json($arr,200);
    			}else{
    					
    				$arr = [ 
    						'status' => 0, 
	    		 			'message' => 'Coupon code you have already use.'
	    		 		];
	    				return response()->json($arr,422);	
    			}
    		}else{
    			$arr = [ 
    				'status' => 0,
	    		 	'message' => 'Coupon Code is Incorrect'
    		 	];
    			return response()->json($arr,422);
    		}
    	}else{
    		 $arr = [ 
    			'status' => 0,
    		 	'message' => 'Please Fill the Input field'
    		 ];
    		return response()->json($arr,422);
    	}
    }

    public function thankYouBid($id){
        $product_bid = ProductBid::where('id',$id)->orderBy('created_at','desc')->with('couponBid.coupon')->first();
        return view('web.dashboard.bids.thankyou',compact('product_bid'));
    }
    public function edit($id){
        // if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
        if(!empty(Auth::user()->paymentCreditCard)){
            $product_bid = ProductBid::where('id',$id)->with('productSize.productTypeSize')->first();
            $product = Product::where('id',$product_bid->product_id)->first();
            $setting = Setting::where('key','paypal_fee')->first();
            $difference = 0;
            $product_ask = ProductAsk::selectRaw('MAX(ask) as max,MAX(expires_at) expiry')
                                            ->where('product_id',$product_bid->product_id)
                                            ->where('product_size_id',$product_bid->product_size_id)
                                            ->where('ask_status','active')
                                            ->where('condition',$product_bid->condition)
                                            ->orderby('expires_at','desc')
                                            ->first();
            if(!empty($product_ask->max)){
                $expiry = date('Y-m-d', strtotime($product_ask->expiry. ' + 1 days'));
                $expiry = new Carbon($expiry);
                $now = Carbon::yesterday();
                $difference = $expiry->diff($now)->days;
            }else{
                flash("Sorry, You can't update the Bid yet, Because Currently no Ask place against this size and condition")->error();
                return redirect()->back();
            }
            return view('web.dashboard.bids.edit-bid',compact('product','setting','product_bid','difference'));
        }else{
            flash('Error!, Please Add the credit card (mandatory payment method)');
            return redirect()->route('seller.setting.index');
        }
    }
    public function update(Request $request){ 
        $this->validate($request, [
            'bid' => 'required',
            'term_condition' => 'required',
            'expiry_day' => 'required',
        ]);
        $setting = Setting::where('key','paypal_fee')->first();
        


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
     
        



        // if($setting->value > 0){
        //     $transaction_fee = ((float)$setting->value/100)*$bid;
        //     if(request()->coupon_code){ 
        //         $total = (float)$bid + (float)$transaction_fee - (float)$coupon->discount_amount;
        //         if($total < 0){
        //             $total = 0;
        //         }
        //     }else{
        //         $total = (float)$bid + (float)$transaction_fee;
        //     }
        // }else{
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
                //flash('Success, Record Saved Successfully.')->success();
                return redirect()->route('seller.bid.thankyou',$product_bid->id);
            }else{
                flash('Error, Something went wrong')->error();
                return redirect()->back();
            }
        }else{
            flash('Error, Something went wrong')->error();
            return redirect()->back();
        }
        
    }
}
