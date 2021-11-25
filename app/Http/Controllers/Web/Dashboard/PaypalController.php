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
use Config;
use Helper;
use Auth;
use DB;
use App\Http\Models\UserPaymentMethodDetail;
use App\Http\Models\PaymentMethod;


class PaypalController extends Controller
{
    private $api_context;
	public function __construct()
    {
    	
        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret'))
        );
        $this->api_context->setConfig(config('services.paypal.settings'));
    }

    public function accountVerification(){
    	
    	$return_ = request()->return_url;
    	request()->session()->forget('return_url');
    	if(!empty($return_)){
    		request()->session()->put('return_url',$return_);
    		request()->session()->save();
    	}
        $pay_amount = 0.1;
    	$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		$item1 = new Item();
		$item1->setName('Paypal Account Verification')
		    ->setCurrency('GBP')
		    ->setQuantity(1)
		    ->setSku("123123")
		    ->setPrice($pay_amount);
	 
		$itemList = new ItemList();
		$itemList->setItems(array($item1));
		 
    	$amount = new Amount();
		$amount->setCurrency("GBP")
		    ->setTotal($pay_amount); 
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription("Paypal Account Verification")
			->setInvoiceNumber(uniqid());
		//$baseUrl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('seller.paypal.confirm_deposit'))
        ->setCancelUrl(route('seller.paypal.confirm_deposit'));
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
	     
	     if(!empty($approvalUrl)) {
	    
	     	request()->session()->put('amount', $pay_amount);
            return redirect($approvalUrl);
        }else {	
        	flash('Something Went Wrong')->error();	
        	if(!empty(request()->return_url)){ 
        		return redirect(request()->return_url);
        	}else{
        		return redirect()->route('seller.setting.index');
        	}
        }
	}
    public function confirmAccountVerification(Request $request)
    {
        dd('hello');
        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
        	flash('Something Went Wrong')->error();	
        	if(!empty(request()->session()->get('return_url'))){ 
        		return redirect(request()->session()->get('return_url'));
        	}else{
        		return redirect()->route('seller.setting.index');
        	}
        }
        try {
			$payment = Payment::get($request->query('paymentId'), $this->api_context);
		    $execution = new PaymentExecution();
		    $execution->setPayerId($request->query('PayerID'));
		    $result = $payment->execute($execution, $this->api_context);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		    flash('Something Went Wrong')->error();	
        	if(!empty(request()->session()->get('return_url'))){ 
        		return redirect(request()->session()->get('return_url'));
        	}else{
        		return redirect()->route('seller.setting.index');
        	}
		} catch (Exception $ex) {
		    flash('Something Went Wrong')->error();	
        	if(!empty(request()->session()->get('return_url'))){ 
        		return redirect(request()->session()->get('return_url'));
        	}else{
        		return redirect()->route('seller.setting.index');
        	}
		}		    
		    if ($result->getState() != 'approved')
		    {
		    	flash('Payment was not successfully Something went wrong')->error();	
        		if(!empty(request()->session()->get('return_url'))){ 
        			return redirect(request()->session()->get('return_url'));
	        	}else{
	        		return redirect()->route('seller.setting.index');
	        	}
		    }
		    $amount = request()->session()->get('amount');
		    request()->session()->forget('amount');
		    $payment_method = PaymentMethod::where('key','paypal')->first();
		    $payment_detail = new UserPaymentMethodDetail();
			$payment_detail->type 					= 'paypal';
			$payment_detail->status 				= 'active'; 
			$payment_detail->payer_id 				= $request->query('PayerID'); 
			$payment_detail->paypal_payment_id 		= $request->query('paymentId'); 
			$payment_detail->first_transec_amount 	= $amount;
			$payment_detail->user_id 				= Auth::user()->id;
			$payment_detail->payment_id 			= $payment_method->id;
			$payment_detail->save();
			flash('Paypal Account Verified Successfully')->success();	
        	if(!empty(request()->session()->get('return_url'))){ 
        		return redirect(request()->session()->get('return_url'));
        	}else{
        		return redirect()->route('seller.setting.index');
        	}
    }

    public function accountVerificationCheckOut($id){
    	request()->session()->forget('product_p_id');
    	request()->session()->put('product_p_id',$id);
    	request()->session()->save();
        $pay_amount = 0.1;
    	$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		$item1 = new Item();
		$item1->setName('Paypal Account Verification')
		    ->setCurrency('GBP')
		    ->setQuantity(1)
		    ->setSku("123123")
		    ->setPrice($pay_amount);
	 
		$itemList = new ItemList();
		$itemList->setItems(array($item1));
		 
    	$amount = new Amount();
		$amount->setCurrency("GBP")
		    ->setTotal($pay_amount); 
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription("Paypal Account Verification")
			->setInvoiceNumber(uniqid());
		//$baseUrl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('seller.paypal.checkout_confirm_deposit'))
        ->setCancelUrl(route('seller.paypal.checkout_confirm_deposit'));
		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));
		
		//$request = clone $payment;
	    try {
            $payment->create($this->api_context);
        } catch (PayPalConnectionException $ex){
            return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'))->withError('Some error occur, sorry for inconvenient');
        } catch (Exception $ex) {
            return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'))->withError('Some error occur, sorry for inconvenient');
        }
	    
	    $approvalUrl = $payment->getApprovalLink();
	     // dd($approvalUrl);
	     if(!empty($approvalUrl)) {
	     	request()->session()->put('amount', $pay_amount);
            return redirect($approvalUrl);
        }else {	
        	flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'));
			
        }
	}
    public function confirmAccountVerificationCheckOut(Request $request)
    {
        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
        	flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'));
        }
        try {
			$payment = Payment::get($request->query('paymentId'), $this->api_context);
		    $execution = new PaymentExecution();
		    $execution->setPayerId($request->query('PayerID'));
		    $result = $payment->execute($execution, $this->api_context);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		    flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'));
		} catch (Exception $ex) {
		    flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'));
		}		    
		    if ($result->getState() != 'approved')
		    {
		    	flash('Payment was not successfully Something went wrong')->error();	
        		return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id')); 
		    }
		    $amount = request()->session()->get('amount');
		    request()->session()->forget('amount');
		    $payment_method = PaymentMethod::where('key','paypal')->first();
		    $payment_detail = new UserPaymentMethodDetail();
			$payment_detail->type 					= 'paypal';
			$payment_detail->status 				= 'active'; 
			$payment_detail->payer_id 				= $request->query('PayerID'); 
			$payment_detail->paypal_payment_id 		= $request->query('paymentId'); 
			$payment_detail->first_transec_amount 	= $amount;
			$payment_detail->user_id 				= Auth::user()->id;
			$payment_detail->payment_id 			= $payment_method->id;
			$payment_detail->save();
			flash('Paypal Account Verified Successfully')->success();	
        	return redirect()->route('seller.buy.product_size',request()->session()->get('product_p_id'));
    }
	

	public function accountVerificationCheckOutSell($id){
    	request()->session()->forget('product_p_id');
    	request()->session()->put('product_p_id',$id);
    	request()->session()->save();
        $pay_amount = 0.1;
    	$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		$item1 = new Item();
		$item1->setName('Paypal Account Verification')
		    ->setCurrency('GBP')
		    ->setQuantity(1)
		    ->setSku("123123")
		    ->setPrice($pay_amount);
	 
		$itemList = new ItemList();
		$itemList->setItems(array($item1));
		 
    	$amount = new Amount();
		$amount->setCurrency("GBP")
		    ->setTotal($pay_amount); 
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($itemList)
			->setDescription("Paypal Account Verification")
			->setInvoiceNumber(uniqid());
		//$baseUrl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl(route('seller.paypal.checkout_confirm_deposit_sell'))
        ->setCancelUrl(route('seller.paypal.checkout_confirm_deposit_sell'));
		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));
		
		//$request = clone $payment;
	    try {
            $payment->create($this->api_context);
        } catch (PayPalConnectionException $ex){
            return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'))->withError('Some error occur, sorry for inconvenient');
        } catch (Exception $ex) {
            return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'))->withError('Some error occur, sorry for inconvenient');
        }
	    
	    $approvalUrl = $payment->getApprovalLink();
	     // dd($approvalUrl);
	     if(!empty($approvalUrl)) {
	     	request()->session()->put('amount', $pay_amount);
            return redirect($approvalUrl);
        }else {	
        	flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'));
        }
	}
    public function confirmAccountVerificationCheckOutSell(Request $request)
    {
        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
        	flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'));
        }
        try {
			$payment = Payment::get($request->query('paymentId'), $this->api_context);
		    $execution = new PaymentExecution();
		    $execution->setPayerId($request->query('PayerID'));
		    $result = $payment->execute($execution, $this->api_context);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		    flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'));
		} catch (Exception $ex) {
		    flash('Something Went Wrong')->error();	
        	return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'));
		}		    
		    if ($result->getState() != 'approved')
		    {
		    	flash('Payment was not successfully Something went wrong')->error();	
        		return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id')); 
		    }
		    $amount = request()->session()->get('amount');
		    request()->session()->forget('amount');
		    $payment_method = PaymentMethod::where('key','paypal')->first();
		    $payment_detail = new UserPaymentMethodDetail();
			$payment_detail->type 					= 'paypal';
			$payment_detail->status 				= 'active'; 
			$payment_detail->payer_id 				= $request->query('PayerID'); 
			$payment_detail->paypal_payment_id 		= $request->query('paymentId'); 
			$payment_detail->first_transec_amount 	= $amount;
			$payment_detail->user_id 				= Auth::user()->id;
			$payment_detail->payment_id 			= $payment_method->id;
			$payment_detail->save();
			flash('Paypal Account Verified Successfully')->success();	
        	return redirect()->route('seller.sell.product_size',request()->session()->get('product_p_id'));
    }
   
}
