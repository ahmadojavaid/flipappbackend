<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\Setting;
use App\Http\Models\ProductAsk;
use Auth;
use Carbon\Carbon;

class AskController extends Controller
{
    public function index($id){
//         dd(session()->all());
        // if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
        // if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $product = Product::where('id',$id)->first();
            $setting = Setting::where('key','paypal_fee')->first();
            $shipment_fee = Setting::where('key','shipment_fee')->first();
            return view('web.dashboard.asks.index',compact('product','setting','shipment_fee'));
        // }else{
        //     flash('Error!, Please Add the at least one payment method');
        //     return redirect()->route('seller.setting.index');
        // }


    }
    public function storeAsk(Request $request){
         // dd(request()->all());
    	$setting = Setting::where('key','paypal_fee')->first();
        $this->validate($request, [
            'ask' => 'required',
            'term_condition' => 'required',
            'expiry_day' => 'required',
        ]);
        if(empty(Auth::user()->paymentPaypal)  && empty(Auth::user()->paymentCreditCard)){
            flash('Error!, Please Add the at least one payment method')->error();
            return redirect()->back();
        }

    	$product_id = request()->product_id;
    	$product_size_id = request()->product_size;
    	$ask = request()->ask;
    	$expiry_date = Carbon::now()->addDays(request()->expiry_day);
    	$expiry_date = $expiry_date->toDateString();
        if(!empty($product_id) && !empty($product_size_id)){
            $productAsk = ProductAsk::where('product_id',$product_id)
                                      ->where('product_size_id',$product_size_id)
                                      ->where('seller_id',Auth::user()->id)
                                      ->where('condition',session('condition'))
                                      ->where(function($qry){
                                        $qry->where('ask_status','active')
                                            ->orWhere('ask_status','inactive');
                                      })
                                      ->first();
            if($productAsk){
                flash("Error, You can't place a Ak. Your Ask already placed.")->error();
                return redirect()->back();
            }
        }else{
            flash("Error, Something went wrong")->error();
            return redirect()->back();
        }


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
    	$product_ask->transaction_fee = $transaction_fee;
        $product_ask->expires_at = $expiry_date;
        $product_ask->condition = session('condition');
    	$product_ask->seller_id = Auth::user()->id;
    	$product_ask->ask_status = 'active';
    	$product_ask->total = $total;
    	$is_saved = $product_ask->save();
    	if($is_saved){
            session()->forget('condition');
        	//flash('Success, Record Updated Successfully.')->success();
        	return redirect()->route('seller.ask.thankyou',$product_ask->id);
    	}else{
    		flash('Error, Something went wrong')->error();
    		return redirect()->back();
    	}
    }
    public function thankYouAsk($id){
        $product_ask = ProductAsk::where('id',$id)->first();
        $setting = Setting::where('key','paypal_fee')->first();
        return view('web.dashboard.asks.thankyou',compact('product_ask','setting'));
    }
    public function edit($id){
        if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $product_ask = ProductAsk::where('id',$id)->with('productSize.productTypeSize')->first();
            $product = Product::where('id',$product_ask->product_id)->first();
            $setting = Setting::where('key','paypal_fee')->first();
            $shipment_fee = Setting::where('key','shipment_fee')->first();
            return view('web.dashboard.asks.edit-ask',compact('product','setting','product_ask','shipment_fee'));
        }else{
            flash('Error!, Please Add the at least one payment method');
            return redirect()->route('seller.setting.index');
        }
    }
    public function update(Request $request){
        $setting = Setting::where('key','paypal_fee')->first();
        $this->validate($request, [
            'ask' => 'required',
            'term_condition' => 'required',
            // 'expiry_day' => 'required',
        ]);

        $product_id = request()->product_id;
        $product_size_id = request()->product_size;
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

                //flash('Success, Record Updated Successfully.')->success();
                return redirect()->route('seller.ask.thankyou',$product_ask->id);
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
