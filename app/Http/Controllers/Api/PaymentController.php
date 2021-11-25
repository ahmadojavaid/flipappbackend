<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\PaymentMethod;
use Braintree_Transaction;
use Braintree_Customer;
use Braintree_CreditCard;
use Braintree_MerchantAccount;
use App\Http\Models\UserPaymentMethodDetail;
use Illuminate\Support\Facades\Validator;
use Auth;

class PaymentController extends ApiController
{
    public function getPaymentMethods(){
    	$payment = PaymentMethod::all();
    	$arr = [
    		'paymentMethods' => $payment,
    	];
    	$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Fetch all payment methods successfully';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    public function addCreditCard(Request $request){
        // dd('hello');
    	$validator = Validator::make($request->all(), [
			            'owner' 	=> 'required',
			            'cvv' 		=> 'required',
			            'card' 		=> 'required',
			            'exp_m' 	=> 'required',
			        ]);
    	if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $card_exist = UserPaymentMethodDetail::where('user_id',Auth::user()->id)
        										->where('digit',substr($request->card,-4))
        										->where('status','active')
        										->get();
        if(count($card_exist) > 0){
        	$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Credit Card Already added.';
            return response()->json($this->apiHelper->responseParse(),422);
            die();
        }
    	$name = $request->owner;	 	
	    $cvv = $request->cvv;
	    $card = $request->card;
	    $exp_m = $request->exp_m;
	    $d = explode('/', $exp_m);
	    $re = Braintree_Customer::create();
	    if($re){
	      $result = Braintree_CreditCard::create([
	        'customerId' => $re->customer->id,
	        'number' => $card,
	        'cardholderName' => $name,
	        'expirationDate' => $d[1].'/'.$d[0],
	      ]);
	      
	      if($result->success){
	        if(!$result->creditCard->expired){
	          $payment_method = PaymentMethod::where('key','credit_card')->first();
	          $payment = new UserPaymentMethodDetail();
	          $payment->digit = $result->creditCard->last4;
	          $payment->status = 'active';
	          $payment->type = 'credit_card';
	          $payment->braintree_customer_id = $re->customer->id;
	          $payment->credit_card_token = $result->creditCard->token;
	          $payment->user_id = Auth::user()->id;
	          $payment->payment_id = $payment_method->id;
	          $payment->save();
	          $arr = [
	          	'creditCardDetails' => $payment 
	          ];
	          $this->apiHelper->statusCode     = 1;
	          $this->apiHelper->statusMessage  = 'Your Card Added Successfully';
	          $this->apiHelper->result         = $arr;
	          return response()->json($this->apiHelper->responseParse(),200);
	        }else{
	          	$this->apiHelper->statusCode     = 0;
		        $this->apiHelper->statusMessage  = 'Your Card Is Expired'; 
		        return response()->json($this->apiHelper->responseParse(),422);
	        }
	      }else{
	        $this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = $result->message; 
	        return response()->json($this->apiHelper->responseParse(),422);
	      }
	    }else{
		    $this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = 'Something went wrong!'; 
	        return response()->json($this->apiHelper->responseParse(),422);
	    } 
    }
    public function getUserVerifiedPaymentMethod(){
    	$credit_card = UserPaymentMethodDetail::where('user_id',Auth::user()->id)
    									->where('type','credit_card')
    									->where('status','active')
    									->first();
    	$paypal 	 = UserPaymentMethodDetail::where('user_id',Auth::user()->id)
    									->where('type','paypal')
    									->where('status','active')
    									->first();
    	$arr = [
    		'paypal' => $paypal,
    		'credit_card' => $credit_card
    	];
    	if(!empty($paypal) || !empty($credit_card)){
    		$this->apiHelper->statusCode     = 1;
	        $this->apiHelper->statusMessage  = 'All Verified Payment methods';
	        $this->apiHelper->result  		 = $arr; 
	        return response()->json($this->apiHelper->responseParse(),200);
    	}else{
    		$this->apiHelper->statusCode     = 0;
	        $this->apiHelper->statusMessage  = 'No Verified Payment Method Found';
	        return response()->json($this->apiHelper->responseParse(),200);
    	}
    	
    }
    
       public function savePaymentDetails(Request $request){
        $payment_method = PaymentMethod::where('key','paypal')->first();
        $payment_detail = new UserPaymentMethodDetail();
        $payment_detail->type 					= 'paypal';
        $payment_detail->status 				= 'active';
        $payment_detail->payer_id 				= $request->query('PayerID');
        $payment_detail->paypal_payment_id 		= $request->query('paymentId');
        $payment_detail->first_transec_amount 	= $request->amount;
        $payment_detail->user_id 				= Auth::user()->id;
        $payment_detail->payment_id 			= $payment_method->id;
        $payment_detail->save();

        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'PayPal method added';
        return response()->json($this->apiHelper->responseParse(),200);
    }

    public function paymentMerchent(){
    	$merchantAccountParams = [
		  'individual' => [
		    'firstName' => 'Jane',
		    'lastName' => 'Doe',
		    'email' => 'jane@14ladders.com',
		    'phone' => '5553334444',
		    'dateOfBirth' => '1981-11-19',
		    'ssn' => '456-45-4567',
		    'address' => [
		      'streetAddress' => '111 Main St',
		      'locality' => 'Chicago',
		      'region' => 'IL',
		      'postalCode' => '60622'
		    ]
		  ],
		  'business' => [
		    'legalName' => 'Jane\'s Ladders',
		    'dbaName' => 'Jane\'s Ladders',
		    'taxId' => '98-7654321',
		    'address' => [
		      'streetAddress' => '111 Main St',
		      'locality' => 'Chicago',
		      'region' => 'IL',
		      'postalCode' => '60622'
		    ]
		  ],
		  'funding' => [
		    'descriptor' => 'Blue Ladders',
		    'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
		    'email' => 'funding@blueladders.com',
		    'mobilePhone' => '5555555555',
		    'accountNumber' => '1123581321',
		    'routingNumber' => '071101307'
		  ],
		  'tosAccepted' => true,
		  'masterMerchantAccountId' => "jobesk",
		];
		$result = Braintree_MerchantAccount::create($merchantAccountParams);
		dd($result);
    }
}
