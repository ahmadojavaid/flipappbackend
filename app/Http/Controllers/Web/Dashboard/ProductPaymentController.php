<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;
use Braintree_Transaction;
use Braintree_Customer;
use Braintree_CreditCard;
use Config;
use Helper;
use Auth;
use DB;
use App\Http\Models\Product;
use App\Http\Models\ProductAsk;
use App\Http\Models\ProductBid;
use App\Http\Models\Setting;
use App\Http\Models\Coupon;
use App\Http\Models\CouponUser;
use App\Http\Models\ProductSale;
use App\Http\Models\Country;
use App\Http\Models\UserPaymentMethodDetail;
use App\User;


class ProductPaymentController extends Controller
{
	private $api_context;
	public function __construct()
    {

        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret'))
        );
        $this->api_context->setConfig(config('services.paypal.settings'));
    }
    /************* For Buying ***********/
    public function buyNow($id){

        // dd('hello');
    	if(request()->size_id){
    		request()->session()->forget('size_id');
    		request()->session()->put('size_id',request()->size_id);
	    	request()->session()->save();
	    	return redirect()->route('seller.buy.product_size',request()->product_id);
    	}

    	// if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $product = Product::where('id',$id)->first();
//    	dd($product);
            if($product){
            	$product_ask = ProductAsk::selectRaw('MIN(ask) as min_ask,ask as ask, id,product_size_id,seller_id')
            							->where('ask_status','active')
            							->where('product_id',$product->id)
            							->where('product_size_id',session('size_id'))
            							->where('condition',session('condition'))
            							->with('productSize.productTypeSize')
            							->first();

//            	dd(Auth::user()->id);

//                dd($product_ask);
	        	if($product_ask){
                    if($product_ask->seller_id == Auth::user()->id){
                        flash('You Can\'t Buy Your Own Ask')->error();
                        return redirect()->back();
                    }
	        		$setting = Setting::where('key','paypal_fee')->first();
                    $countries = Country::all();
                    // $transaction_fee = (float)$product_ask->min_ask/100*(float)$setting->value;
	        		$transaction_fee = 0;
                    $payment_methods = \App\Http\Models\PaymentMethod::all();
		            $shipment_fee = Setting::where('key','shipment_fee')->first();
                    // return view('web.dashboard.buying.index',compact('product','setting','shipment_fee','product_ask','transaction_fee'));
		            return view('web.dashboard.checkout.buying.index',compact('product','setting','shipment_fee','product_ask','transaction_fee','payment_methods','countries'));
	        	}else{
	            	return redirect()->route('single_product',$id);
	        	}
            }else{
            	return redirect()->route('single_product',$id);
        	}
        // }else{
        //     flash('Error!, Please Add the at least one payment method');
        //     return redirect()->route('seller.setting.index');
        // }
    }
    public function paymentProcess(){

//        dd('hello');
    	// dd(request()->coupon_code);
    	if(empty(request()->payment_by)){
        	flash('Please choose the at least one payment method')->error();
        	return redirect()->back();
    	}
        $payment_method = UserPaymentMethodDetail::where('user_id',Auth::user()->id)
                                                    ->where('type',request()->payment_by)
                                                    ->where('status','active')
                                                    ->first();
        if($payment_method){}else{
           flash('Please Verified Your Payment Method')->error();
            return redirect()->back();
        }
        if(empty(Auth::user()->deliveryAddress)){
            flash('Please Add Delivery Address')->error();
            return redirect()->back();
        }

    	$product_id = request()->product_id;
    	$product_size_id = session('size_id');
    	$condition = 'new';
    	$payment_via = request()->payment_by;
    	$product_ask = ProductAsk::selectRaw('MIN(ask) as min_ask,ask as ask, id,product_size_id,seller_id,product_id,product_size_id')
            							->where('ask_status','active')
            							->where('product_id',$product_id)
            							->where('product_size_id',$product_size_id)
            							->where('condition',$condition)
            							->with('productSize.productTypeSize')
            							->first();
        if($product_ask){
        	if($payment_via == 'paypal'){
        		request()->session()->put('product_id',$product_id);
        		request()->session()->put('ask_amount',$product_ask->min_ask);
        		request()->session()->put('seller_id',$product_ask->seller_id);
        		$total = $this->calculateAmount('paypal',$product_ask->ask);
        		request()->session()->put('total_amount',$total);
        		request()->session()->put('ask_id',$product_ask->id);
        		if(request()->coupon_code){
        			$coupon = Coupon::where('code',request()->coupon_code)->first();
        			if($coupon){
        				request()->session()->put('coupon_code',$coupon->code);
        				request()->session()->put('coupon_id',$coupon->id);
        				$total = (float)$total - (float)$coupon->discount_amount;
        				request()->session()->put('coupon_amount',$coupon->discount_amount);

        			}
        		}
        		request()->session()->save();
        		$arr = $this->paypalProcess($total);

//        		dd($arr);

        		if($arr['status'] == 1){
        			return redirect($arr['url']);
        		}else{
        			flash('Something wrong in paypal')->error();
        			return redirect()->back();
        		}
	    	}elseif($payment_via == 'credit_card'){
        		$total = $this->calculateAmount('credit_card',$product_ask->ask);
        		if(request()->coupon_code){
        			$coupon = Coupon::where('code',request()->coupon_code)->first();
        			if($coupon){
        				request()->session()->put('coupon_code',$coupon->code);
        				request()->session()->put('coupon_id',$coupon->id);
        				$total = (float)$total - (float)$coupon->discount_amount;
        				request()->session()->put('coupon_amount',$coupon->discount_amount);
        			}
        		}
        		request()->session()->put('ask_id',$product_ask->id);
        		request()->session()->save();
        		$arr = $this->creditdCardProcess($total,$product_ask);
        		if($arr['status'] == 0 && $arr['card_expired'] == 1){
        			flash('Your Credit Card is Expired');
        			return redirect()->route('seller.setting.index');
        		}elseif($arr['status'] == 1){
        			$product_sale = ProductSale::orderBy('created_at','desc')->first();
        			return view('web.dashboard.buying.thankyou',compact('product_sale'));
        		}elseif($arr['status'] == 2){
        			flash('Credit Card Not Found.')->error();
        			return redirect()->back();
        		}elseif($arr['status'] == 3){
        			flash($arr['message'])->error();
        			return redirect()->back();
        		}
	    	}
        }else{
        	flash('Something went wrong.')->error();
        	return redirect()->back();
        }

    }
    public function calculateAmount($type,$min_ask){
    	if($type == 'paypal'){
    		// $setting = Setting::where('key','paypal_fee')->first();
            // $transaction_fee = (float)$min_ask/100*(float)$setting->value;
    		$transaction_fee = 0;
        	request()->session()->put('transaction_fee',$transaction_fee);
    		$transaction_fee = (float)$min_ask + (float)$transaction_fee;
    	}elseif($type == 'credit_card'){
    		// $setting = Setting::where('key','paypal_fee')->first();
            // $transaction_fee = (float)$min_ask/100*(float)$setting->value;
    		$transaction_fee = 0;
    		request()->session()->put('transaction_fee',$transaction_fee);
    		$transaction_fee = (float)$min_ask + (float)$transaction_fee;
    	}
    	return $transaction_fee;
    }

    public function paypalProcess($total_amount){
        $pay_amount = $total_amount;
    	$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		$item1 = new Item();
		$item1->setName('Buy Now')
		    ->setCurrency('USD')
		    ->setQuantity(1)
		    ->setSku("123123")
		    ->setPrice($pay_amount);

		$itemList = new ItemList();
		$itemList->setItems(array($item1));

    	$amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal($pay_amount);
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription("Buy Ask")
			->setInvoiceNumber(uniqid());
		//$basUSDl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('seller.buy.confirm_paypal'))
        ->setCancelUrl(route('seller.buy.confirm_paypal'));
		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));

		//$request = clone $payment;
	    try {
            $payment->create($this->api_context);
        } catch (PayPalConnectionException $ex){
            return back()->withError('Some error occur, sorry for inconvenient');
        } catch (Exception $ex) {
            return back()->withError('Some error occur, sorry for inconvenient');
        }

	    $approvalUrl = $payment->getApprovalLink();



	     // dd($approvalUrl);
	     if(!empty($approvalUrl)) {
	     	// request()->session()->put('amount', $pay_amount);
	     	$arr = [
	     		'status'	=> 1,
	     		'url' 		=> $approvalUrl,

	     	];
           	return $arr;
        }else {
        	$arr = [
        		'status'	=> 0,
        		'url' 		=> '',

	     	];
           	return $arr;

        }
    }






    public function confirmPaypalProcess(Request $request)
    {

        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
        	flash('Something Went Wrong')->error();
        	$product_id = request()->session()->get('product_id');
        	$size_id = request()->session()->get('size_id');
        	request()->session()->forget([
				'seller_id',
				'product_id',
				'ask_amount',
				'ask_id',
				'total_amount',
				'transaction_fee',
				'coupon_code',
				'coupon_amount',
				'coupon_id',
				// 'condition',
			]);

        	return redirect('seller/buy/product/'.$product_id.'?size_id='.$size_id);

        }
        try {
			$payment = Payment::get($request->query('paymentId'), $this->api_context);
		    $execution = new PaymentExecution();
		    $execution->setPayerId($request->query('PayerID'));
		    $result = $payment->execute($execution, $this->api_context);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		    flash('Something Went Wrong')->error();
        	return redirect()->route('seller.buy.product_size');
		} catch (Exception $ex) {
		    flash('Something Went Wrong')->error();
        	return redirect()->route('seller.buy.product_size');
		}
		    if ($result->getState() != 'approved')
		    {
		    	flash('Payment was not successfully Something went wrong')->error();
        		return redirect()->route('seller.buy.product_size');
		    }
		    // dd(session()->all());
		    $amount = request()->session()->get('amount');
		    $user_paypal = Auth::user()->paymentPaypal()->first();
		    $product_ask  = ProductAsk::where('id',request()->session()->get('ask_id'))->first();
            $product_ask->ask_status = 'buy';
            $product_ask->save();
		   	$product_sale = new ProductSale();
		   	$product_sale->buyer_id 		= Auth::user()->id;
		   	$product_sale->seller_id 		= request()->session()->get('seller_id');
		   	$product_sale->product_id 		= request()->session()->get('product_id');
		   	$product_sale->product_size_id 	= request()->session()->get('size_id');
		   	$product_sale->sale_price 		= request()->session()->get('ask_amount');
		   	$product_sale->total_amount 	= request()->session()->get('total_amount');
            $product_sale->payment_status   = 'processed';
		   	$product_sale->condition 	    = session('condition');
		   	$product_sale->transaction_fee 	= request()->session()->get('transaction_fee');
		   	$product_sale->paypal_payment_id = $request->query('paymentId');
    		$product_sale->user_payment_method_detail_id = $user_paypal->id;

		   	if(!empty(request()->session()->get('coupon_code'))){
		   		$product_sale->coupon_code 	= request()->session()->get('coupon_code');
		   		$product_sale->coupon_amount= request()->session()->get('coupon_amount');
		   	}
		   	$product_sale->process_via 		= 'paypal';
		   	$is_saved = $product_sale->save();
		   	if($is_saved){
	   			if(!empty(request()->session()->get('coupon_code'))){
	   				$coupon_user = new CouponUser();
	   				$coupon_user->user_id = Auth::user()->id;
	   				$coupon_user->coupon_id = request()->session()->get('coupon_id');
	   				$coupon_user->object_id = $product_sale->id;
	   				$coupon_user->object_type = 'buys';
	   				$coupon_saved = $coupon_user->save();
	   				if($coupon_saved){
	   					request()->session()->forget([
	   													'seller_id',
	   													'product_id',
	   													'size_id',
	   													'ask_amount',
	   													'ask_id',
	   													'total_amount',
	   													'transaction_fee',
	   													'coupon_code',
	   													'coupon_amount',
	   													'coupon_id',
	   													'condition',
	   												]);

	   				}
	   			}
	   			return view('web.dashboard.buying.thankyou',compact('product_sale'));
		   	}
    }
    public function creditdCardProcess($total,$product_ask){
    	$user_credit_card = Auth::user()->paymentCreditCard('credit_card')->first();
    	if($user_credit_card){
    		$is_expired = Braintree_CreditCard::find($user_credit_card->credit_card_token);

    		if($is_expired->expired == true){

    				$user_credit_card->status = 'expire';
    				$user_credit_card->save();
    				$arr = [
    					'status' => 0,
    					'card_expired' => 1
    				];
    				return $arr;
    				//return redirect()->route('seller.setting.index');
    		}
    		$transaction = Braintree_Transaction::sale([
												'amount' => $total,
												'paymentMethodToken' => $user_credit_card->credit_card_token,
												'options' => [
                                   							'submitForSettlement' => True
                                     					]
                                     			]);

    		if($transaction->success){
		    	$product_asks  = ProductAsk::where('id',request()->session()->get('ask_id'))->first();
                $product_asks->ask_status = 'buy';
                $product_asks->save();
    			$product_sale = new ProductSale();
    			$product_sale->seller_id = $product_ask->seller_id;
    			$product_sale->buyer_id	 = Auth::user()->id;
    			$product_sale->product_id = $product_ask->product_id;
    			$product_sale->product_size_id = $product_ask->product_size_id;
    			$product_sale->sale_price = $product_ask->min_ask;
    			$product_sale->total_amount = $total;
                $product_sale->payment_status = 'processed';
    			$product_sale->condition = session('condition');
    			$product_sale->transaction_fee = request()->session()->get('transaction_fee');
    			$product_sale->process_via = 'credit_card';
    			$product_sale->card_transaction_id = $transaction->transaction->id;
    			$product_sale->user_payment_method_detail_id = $user_credit_card->id;
    			if(!empty(request()->session()->get('coupon_code'))){
			   		$product_sale->coupon_code 	= request()->session()->get('coupon_code');
			   		$product_sale->coupon_amount= request()->session()->get('coupon_amount');
		   		}
    			$is_saved = $product_sale->save();
    			if($is_saved){
    				if(!empty(request()->session()->get('coupon_code'))){
		   				$coupon_user = new CouponUser();
		   				$coupon_user->user_id = Auth::user()->id;
		   				$coupon_user->coupon_id = request()->session()->get('coupon_id');
		   				$coupon_user->object_id = $product_sale->id;
		   				$coupon_user->object_type = 'buys';
		   				$coupon_saved = $coupon_user->save();
	   				}
    			}
    			request()->session()->forget(['transaction_fee','coupon_code','coupon_amount','coupon_id','ask_id']);
    			$arr = [
    					'status' => 1,
    					'card_expired' => 0,

    				];
    				return $arr;
    			// return view('web.dashboard.buying.thankyou',compact('product_sale'));
    		}else{
    			$arr = [
    					'status' => 3,
    					'card_expired' => 0,
    					'message' => $transaction->message,
    				];
    			return $arr;
    		}
    	}else{
    		$arr = [
    					'status' => 2,
    					'card_expired' => 0,
    				];
    		return $arr;
    	}
    }

    /******** End For Buying **********/

    /************** For Selling ***************/

    public function sellNow($id){
        // dd(request()->all());
        if(request()->size_id){
            request()->session()->forget('size_id');
            request()->session()->put('size_id',request()->size_id);
            request()->session()->save();
            return redirect()->route('seller.sell.product_size',request()->product_id);
        }

        // if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $product = Product::where('id',$id)->first();
            if($product){
                $product_bid = ProductBid::selectRaw('MAX(bid) as high_bid, id,product_size_id,user_id')
                                        ->where('bid_status','active')
                                        ->where('product_id',$product->id)
                                        ->where('product_size_id',session('size_id'))
                                        ->where('condition',session('condition'))
                                        ->with('productSize.productTypeSize')
                                        ->first();
                if($product_bid){
                    if($product_bid->user_id == Auth::user()->id){
                        flash('You Can\'t Sell Your Own Bid')->error();
                        return redirect()->back();
                    }
                    $setting = Setting::where('key','paypal_fee')->first();
                    $countries = Country::all();
                    $payment_methods = \App\Http\Models\PaymentMethod::all();
                    $transaction_fee = (float)$product_bid->high_bid/100*(float)$setting->value;

                    $shipment_fee = Setting::where('key','shipment_fee')->first();
                    // return view('web.dashboard.selling.index',compact('product','setting','shipment_fee','product_bid','transaction_fee'));
                    return view('web.dashboard.checkout.selling.index',compact('product','setting','shipment_fee','product_bid','transaction_fee','payment_methods','countries'));
                }else{
                    return redirect()->route('single_product',$id);
                }
            }else{
                return redirect()->route('single_product',$id);
            }
        // }else{
        //     flash('Error!, Please Add the at least one payment method');
        //     return redirect()->route('seller.setting.index');
        // }
    }

    public function paymentProcessSell(){
        if(empty(request()->payment_by)){
            flash('Please choose the at least one payment method')->error();
            return redirect()->back();
        }

        $payment_method = UserPaymentMethodDetail::where('user_id',Auth::user()->id)
                                                    ->where('type',request()->payment_by)
                                                    ->where('status','active')
                                                    ->first();
        if($payment_method){}else{
           flash('Please Verified At Least One Payment Method')->error();
            return redirect()->back();
        }
        if(empty(Auth::user()->deliveryAddress)){
            flash('Please Add Delivery Address')->error();
            return redirect()->back();
        }

        $product_id = request()->product_id;
        $product_size_id = session('size_id');
        $condition = 'new';
        $payment_via = request()->payment_by;
        $product_bid = ProductBid::selectRaw('MAX(bid) as high_bid, id,product_size_id,user_id,product_id,product_size_id')
                                        ->where('bid_status','active')
                                        ->where('product_id',$product_id)
                                        ->where('product_size_id',$product_size_id)
                                        ->where('condition',$condition)
                                        ->with('productSize.productTypeSize')
                                        ->first();
                                        // dd($product_bid);
        if($product_bid){
                $total = $this->calculateAmountSell('credit_card',$product_bid->high_bid);
                // if(request()->coupon_code){
                //     $coupon = Coupon::where('code',request()->coupon_code)->first();
                //     if($coupon){
                //         request()->session()->put('coupon_code',$coupon->code);
                //         request()->session()->put('coupon_id',$coupon->id);
                //         $total = (float)$total - (float)$coupon->discount_amount;
                //         request()->session()->put('coupon_amount',$coupon->discount_amount);
                //     }
                // }

                request()->session()->put('prefered',request()->payment_by);
                request()->session()->put('bid_id',$product_bid->id);
                request()->session()->save();
                $arr = $this->creditdCardProcessSell($total,$product_bid);
                // dd($arr);
                if($arr['status'] == 0 && $arr['card_expired'] == 1){
                    flash('Something went wrong')->error();
                    return redirect()->back();
                }elseif($arr['status'] == 1){
                    $setting = Setting::where('key','paypal_fee')->first();
                    $product_sale = ProductSale::orderBy('created_at','desc')->first();
                    return view('web.dashboard.selling.thankyou',compact('product_sale','setting'));
                }elseif($arr['status'] == 2){
                    flash('Something went wrong')->error();
                    return redirect()->back();
                }elseif($arr['status'] == 3){
                    // flash($arr['message'])->error();
                    flash('Something went wrong')->error();
                    return redirect()->back();
                }
        }else{

        }
    }
    public function creditdCardProcessSell($total,$product_bid){
        $user = User::where('id',$product_bid->user_id)->first();
        if($user){
        $user_credit_card = $user->paymentCreditCard('credit_card')->first();
        if($user_credit_card){
            $is_expired = Braintree_CreditCard::find($user_credit_card->credit_card_token);

            if($is_expired->expired == true){

                    $user_credit_card->status = 'expire';
                    $user_credit_card->save();
                    $arr = [
                        'status' => 0,
                        'card_expired' => 1
                    ];
                    return $arr;
                    //return redirect()->route('seller.setting.index');
            }
            $transaction = Braintree_Transaction::sale([
                                                'amount' => $total,
                                                'paymentMethodToken' => $user_credit_card->credit_card_token,
                                                'options' => [
                                                            'submitForSettlement' => True
                                                        ]
                                                ]);

            if($transaction->success){
                $product_bid->bid_status = 'buy';
                $product_bid->save();
                $product_sale = new ProductSale();
                $product_sale->seller_id = Auth::user()->id;
                $product_sale->buyer_id  = $product_bid->user_id;
                $product_sale->product_id = $product_bid->product_id;
                $product_sale->product_size_id = $product_bid->product_size_id;
                $product_sale->sale_price = $product_bid->high_bid;
                $product_sale->total_amount = $total;
                $product_sale->condition = session('condition');
                $product_sale->payment_status = 'processed';
                $product_sale->transaction_fee = request()->session()->get('transaction_fee');
                $product_sale->process_via = 'credit_card';
                $product_sale->prefered_payment_method = request()->session()->get('prefered');
                $product_sale->card_transaction_id = $transaction->transaction->id;
                $product_sale->user_payment_method_detail_id = $user_credit_card->id;
                if(!empty(request()->session()->get('coupon_code'))){
                    $product_sale->coupon_code  = request()->session()->get('coupon_code');
                    $product_sale->coupon_amount= request()->session()->get('coupon_amount');
                }
                $is_saved = $product_sale->save();
                if($is_saved){
                    if(!empty(request()->session()->get('coupon_code'))){
                        $coupon_user = new CouponUser();
                        $coupon_user->user_id = Auth::user()->id;
                        $coupon_user->coupon_id = request()->session()->get('coupon_id');
                        $coupon_user->object_id = $product_sale->id;
                        $coupon_user->object_type = 'buys';
                        $coupon_saved = $coupon_user->save();
                    }
                }
                request()->session()->forget(['transaction_fee','coupon_code','coupon_amount','coupon_id','bid_id','prefered']);
                $arr = [
                        'status' => 1,
                        'card_expired' => 0,

                    ];
                    return $arr;
                // return view('web.dashboard.buying.thankyou',compact('product_sale'));
            }else{
                $arr = [
                        'status' => 3,
                        'card_expired' => 0,
                        'message' => $transaction->message,
                    ];
                return $arr;
            }
        }else{
            $arr = [
                        'status' => 2,
                        'card_expired' => 0,
                    ];
            return $arr;
        }
        }else{
            $arr = [
                        'status' => 2,
                        'card_expired' => 0,
                    ];
            return $arr;
        }
    }
    public function calculateAmountSell($type,$high_bid){
        if($type == 'credit_card'){
            $setting = Setting::where('key','paypal_fee')->first();
            $transaction_fee = (float)$high_bid/100*(float)$setting->value;
            request()->session()->put('transaction_fee',$transaction_fee);
            $transaction_fee = (float)$high_bid + (float)$transaction_fee;
        }
        return $transaction_fee;
    }
    /*
    public function paymentProcessSell(){
        // dd(request()->all());
        if(empty(request()->payment_by)){
            flash('Please choose the at least one payment method')->error();
            return redirect()->back();
        }
        $product_id = request()->product_id;
        $product_size_id = session('size_id');
        $condition = session('condition');
        $payment_via = request()->payment_by;
        $product_bid = ProductBid::selectRaw('MIN(bid) as high_bid, id,product_size_id,user_id,product_id,product_size_id')
                                        ->where('bid_status','active')
                                        ->where('product_id',$product_id)
                                        ->where('product_size_id',$product_size_id)
                                        ->where('condition',$condition)
                                        ->with('productSize.productTypeSize')
                                        ->first();
        if($product_bid){
            if($payment_via == 'paypal'){
                request()->session()->put('product_id',$product_id);
                request()->session()->put('bid_amount',$product_bid->high_bid);
                request()->session()->put('user_id',$product_bid->user_id);
                $total = $this->calculateAmountSell('paypal',$product_bid->high_bid);
                request()->session()->put('total_amount',$total);
                request()->session()->put('bid_id',$product_bid->id);
                if(request()->coupon_code){
                    $coupon = Coupon::where('code',request()->coupon_code)->first();
                    if($coupon){
                        request()->session()->put('coupon_code',$coupon->code);
                        request()->session()->put('coupon_id',$coupon->id);
                        $total = (float)$total - (float)$coupon->discount_amount;
                        request()->session()->put('coupon_amount',$coupon->discount_amount);

                    }
                }
                request()->session()->save();
                $arr = $this->paypalProcessSell($total);

                if($arr['status'] == 1){
                    return redirect($arr['url']);
                }else{
                    flash('Something wrong in paypal')->error();
                    return redirect()->back();
                }
            }elseif($payment_via == 'credit_card'){
                $total = $this->calculateAmount('credit_card',$product_ask->min_ask);
                if(request()->coupon_code){
                    $coupon = Coupon::where('code',request()->coupon_code)->first();
                    if($coupon){
                        request()->session()->put('coupon_code',$coupon->code);
                        request()->session()->put('coupon_id',$coupon->id);
                        $total = (float)$total - (float)$coupon->discount_amount;
                        request()->session()->put('coupon_amount',$coupon->discount_amount);
                    }
                }
                request()->session()->put('ask_id',$product_ask->id);
                request()->session()->save();
                $arr = $this->creditdCardProcess($total,$product_ask);
                if($arr['status'] == 0 && $arr['card_expired'] == 1){
                    flash('Your Credit Card is Expired');
                    return redirect()->route('seller.setting.index');
                }elseif($arr['status'] == 1){
                    $product_sale = ProductSale::orderBy('created_at','desc')->first();
                    return view('web.dashboard.buying.thankyou',compact('product_sale'));
                }elseif($arr['status'] == 2){
                    flash('Credit Card Not Found.')->error();
                    return redirect()->back();
                }elseif($arr['status'] == 3){
                    flash($arr['message'])->error();
                    return redirect()->back();
                }
            }
        }else{
            flash('Something went wrong.')->error();
            return redirect()->back();
        }

    }
    public function calculateAmountSell($type,$high_bid){
        if($type == 'paypal'){
            $setting = Setting::where('key','paypal_fee')->first();
            $transaction_fee = (float)$high_bid/100*(float)$setting->value;
            request()->session()->put('transaction_fee',$transaction_fee);
            $transaction_fee = (float)$high_bid + (float)$transaction_fee;
        }elseif($type == 'credit_card'){
            $setting = Setting::where('key','credit_card')->first();
            $transaction_fee = (float)$high_bid/100*(float)$setting->value;
            request()->session()->put('transaction_fee',$transaction_fee);
            $transaction_fee = (float)$high_bid + (float)$transaction_fee;
        }
        return $transaction_fee;
    }
    public function paypalProcessSell($total_amount){
        // dd($total_amount);


        $pay_amount = $total_amount;
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        $item1 = new Item();
        $item1->setName('Sell Now')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setSku("123123")
            ->setPrice($pay_amount);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($pay_amount);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Sell Ask")
            ->setInvoiceNumber(uniqid());
        //$basUSDl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('seller.sell.confirm_paypal'))
        ->setCancelUrl(route('seller.sell.confirm_paypal'));
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        //$request = clone $payment;
        try {
            $payment->create($this->api_context);
        } catch (PayPalConnectionException $ex){
            return back()->withError('Some error occur, sorry for inconvenient');
        } catch (Exception $ex) {
            return back()->withError('Some error occur, sorry for inconvenient');
        }

        $approvalUrl = $payment->getApprovalLink();



         // dd($approvalUrl);
         if(!empty($approvalUrl)) {
            // request()->session()->put('amount', $pay_amount);
            $arr = [
                'status'    => 1,
                'url'       => $approvalUrl,

            ];
            return $arr;
        }else {
            $arr = [
                'status'    => 0,
                'url'       => '',

            ];
            return $arr;

        }
    }
    public function confirmPaypalProcessSell(Request $request)
    {

        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
            flash('Something Went Wrong')->error();
            $product_id = request()->session()->get('product_id');
            $size_id = request()->session()->get('size_id');
            request()->session()->forget([
                'user_id',
                'product_id',
                'bid_amount',
                'bid_id',
                'total_amount',
                'transaction_fee',
                'coupon_code',
                'coupon_amount',
                'coupon_id',
                // 'condition',
            ]);

            return redirect('seller/sell/product/'.$product_id.'?size_id='.$size_id);

        }
        try {
            $payment = Payment::get($request->query('paymentId'), $this->api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->query('PayerID'));
            $result = $payment->execute($execution, $this->api_context);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            flash('Something Went Wrong')->error();
            return redirect()->route('seller.sell.product_size');
        } catch (Exception $ex) {
            flash('Something Went Wrong')->error();
            return redirect()->route('seller.sell.product_size');
        }
            if ($result->getState() != 'approved')
            {
                flash('Payment was not successfully Something went wrong')->error();
                return redirect()->route('seller.sell.product_size');
            }
            // dd(session()->all());
            $amount = request()->session()->get('amount');
            $user_paypal = Auth::user()->paymentPaypal()->first();
            $product_ask  = ProductBid::where('id',request()->session()->get('bid_id'))->update(['bid_status'=>'buy']);
            $product_sale = new ProductSale();
            $product_sale->buyer_id         = Auth::user()->id;
            $product_sale->seller_id        = request()->session()->get('user_id');
            $product_sale->product_id       = request()->session()->get('product_id');
            $product_sale->product_size_id  = request()->session()->get('size_id');
            $product_sale->sale_price       = request()->session()->get('bid_amount');
            $product_sale->total_amount     = request()->session()->get('total_amount');
            $product_sale->payment_status   = 'processed';
            $product_sale->transaction_fee  = request()->session()->get('transaction_fee');
            $product_sale->paypal_payment_id = $request->query('paymentId');
            $product_sale->user_payment_method_detail_id = $user_paypal->id;

            if(!empty(request()->session()->get('coupon_code'))){
                $product_sale->coupon_code  = request()->session()->get('coupon_code');
                $product_sale->coupon_amount= request()->session()->get('coupon_amount');
            }
            $product_sale->process_via      = 'paypal';
            $is_saved = $product_sale->save();
            if($is_saved){
                if(!empty(request()->session()->get('coupon_code'))){
                    $coupon_user = new CouponUser();
                    $coupon_user->user_id = Auth::user()->id;
                    $coupon_user->coupon_id = request()->session()->get('coupon_id');
                    $coupon_user->object_id = $product_sale->id;
                    $coupon_user->object_type = 'buys';
                    $coupon_saved = $coupon_user->save();
                    if($coupon_saved){
                        request()->session()->forget([
                                                        'user_id',
                                                        'product_id',
                                                        'size_id',
                                                        'bid_amount',
                                                        'bid_id',
                                                        'total_amount',
                                                        'transaction_fee',
                                                        'coupon_code',
                                                        'coupon_amount',
                                                        'coupon_id',
                                                        'condition',
                                                    ]);

                    }
                }
                return view('web.dashboard.buying.thankyou',compact('product_sale'));
            }
    }
    */
}
