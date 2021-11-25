<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use Auth;
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
use App\Http\Models\Product;
use App\Http\Models\ProductAsk;
use App\Http\Models\Setting;

class ProductPaymentController extends ApiController
{
	private $api_context;
	public function __construct()
    {
        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret'))
        );
        $this->api_context->setConfig(config('services.paypal.settings'));
    }
    public function buyNow(Request $request){
    	$validator = Validator::make($request->all(), [
			            'product_id' 		=> 'required',
			            'product_size_id' 	=> 'required',
			        ]);
    	if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }    	
    	if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
    		$id 		= request()->product_id;
    		$size_id 	= request()->product_size_id;
            $product = Product::where('id',$id)->first();
            if($product){
            	$product_ask = ProductAsk::selectRaw('MIN(ask) as min_ask, id,product_size_id,seller_id')
            							->where('ask_status','active')
            							->where('product_id',$id)
            							->where('product_size_id',$size_id)
            							->where('condition','new')
            							->with('productSize.productTypeSize')
            							->first();
	        	if($product_ask){
                    if($product_ask->seller_id == Auth::user()->id){
                        $this->apiHelper->statusCode     = 0;
			            $this->apiHelper->statusMessage  = 'You Can\'t Buy Your Own Ask';
			            return response()->json($this->apiHelper->responseParse(),422);
                    }
	        		$setting = Setting::where('key','paypal_fee')->first();
	        		$transaction_fee = 0;

		            $shipment_fee = Setting::where('key','shipment_fee')->first();
		            $arr = [
		            	'product' 				=> $product,
		            	'shipmentFee'			=> $shipment_fee,
		            	'productAsk'			=> $product_ask,
		            	'verifiedPaymentMethod'	=> [
		            		'Paypal'	 => Auth::user()->paymentPaypal,
		            		'CreditCard' => Auth::user()->paymentCreditCard
		            	],
		            ];
		            $this->apiHelper->statusCode     = 0;
		            $this->apiHelper->statusMessage  = 'Detail fetched Successfully';
		            $this->apiHelper->result 		 = $arr;
		            return response()->json($this->apiHelper->responseParse(),422);
	        	}else{
	            	$this->apiHelper->statusCode     = 0;
		            $this->apiHelper->statusMessage  = 'Something went wrong';
		            return response()->json($this->apiHelper->responseParse(),422);
	        	}
            }else{
            	$this->apiHelper->statusCode     = 0;
	            $this->apiHelper->statusMessage  = 'Product ID is not correct';
	            return response()->json($this->apiHelper->responseParse(),422);
        	}
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Please Add the at least one payment method';
            return response()->json($this->apiHelper->responseParse(),422);
        }
    }

    public function paymentProcess(Request $request){
    	$validator = Validator::make($request->all(), [
			            'product_id' 		=> 'required',
			            'product_size_id' 	=> 'required', 
			            'payment_by'		=> 'required'
			        ]);
    	if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	$product_id 		= request()->product_id;
    	$product_size_id 	= request()->product_size_id;
    	$condition 			= 'new';
    	$payment_via 		= request()->payment_by;
    	$product_ask = ProductAsk::selectRaw('MIN(ask) as min_ask, id,product_size_id,seller_id,product_id,product_size_id')
            							->where('ask_status','active')
            							->where('product_id',$product_id)
            							->where('product_size_id',$product_size_id)
            							->where('condition',$condition)
            							->with('productSize.productTypeSize','user.paymentPaypal')
            							->first();
        if($product_ask){
        	if($payment_via == 'paypal'){
        		$total = $this->calculateAmount('paypal',$product_ask->min_ask);
        		if(request()->coupon_code){
        			$coupon = Coupon::where('code',request()->coupon_code)->first();
        			if($coupon){       				
        				$total = (float)$total - (float)$coupon->discount_amount;
        			}
        		}
        		$a = $this->SellerPayout($product_ask->user->paymentPaypal->payer_id,$total);
                dd($a);
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
        	$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Something went wrong!';
            return response()->json($this->apiHelper->responseParse(),422);
        }
    }

    public function calculateAmount($type,$min_ask){
    	if($type == 'paypal'){
    		$transaction_fee = 0;
    		$transaction_fee = (float)$min_ask + (float)$transaction_fee;
    	}elseif($type == 'credit_card'){
    		$transaction_fee = 0;
    		$transaction_fee = (float)$min_ask + (float)$transaction_fee;
    	}
    	return $transaction_fee;
    }



    public function SellerPayout($payerID, $amount)
    {
        // dd($amount);
	    $payouts = new \PayPal\Api\Payout();

	    $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

	    $senderBatchHeader->setSenderBatchId(mt_rand(100000, 999999))
	        ->setEmailSubject("You have Purchase a Ask!");

	    $senderItem = new \PayPal\Api\PayoutItem();
	    $currenyObj = new \PayPal\Api\Currency(
                                                array('value' => $amount, 'currency' => 'GBP')
                                            );
	    $senderItem->setRecipientType('PAYPAL_ID')
        	        ->setAmount($currenyObj)
        	        ->setNote('Thanks for your Purchasing!')
        	        ->setReceiver($payerID)
        	        ->setSenderItemId(mt_rand(100000, 999999)
        	        );
        // dd($currenyObj);
	    $payouts->setSenderBatchHeader($senderBatchHeader)
	        ->addItem($senderItem);

	    $request = clone $payouts;
	       
	    try {
	    	// dd(1);
            $output = $payouts->create(array('sync_mode' => 'false'), $this->api_context);

	        // $output = $payouts->getApprovalLink($this->api_context);
	         
	    } catch (\Exception $ex) {

	        echo "PayPal Payout GetData:<br>" . $ex->getData() . "<br><br>";
	        //echo("Error something went wrong" . " Payout" . null . $request . $ex);
	        return false;
	    }
	    //echo("Created Single Synchronous Payout   ". "Payout  ". $output->getBatchHeader()->getPayoutBatchId(). $request. $output);
	    return true;
	}
}
