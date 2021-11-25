<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Braintree_Transaction;
use Braintree_Customer;
use Braintree_CreditCard;
use Auth;
use App\Http\Models\UserPaymentMethodDetail;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\PaymentMethod;

class CreditCardController extends Controller
{
  public function verification(Request $request){
    $name = $request->owner;
    $cvv = $request->cvv;
    $card = $request->card;
    $exp_m = $request->exp_m;
    $d = explode('/', $exp_m);
    // $exp_y = $request->exp_y;
    // $nonce = $request->paymentMethodNonce;
    // if(Auth::user()->paymentCreditCard('credit_card'))
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
          flash("Success, Your Card Added Successfully.")->success();
          return redirect()->back();
        }else{
          flash("Error, Your Card Is Expired.")->error();
          return redirect()->back();
        }
      }else{
        flash("Error, ".$result->message)->error();
        return redirect()->back();
      }
    }else{
      flash("Error, Something went wrong")->error();
      return redirect()->back();
    }
  }

  public function verificationCheckOut(Request $request){ 
    $validator = Validator::make($request->all(), [
                      'owner' => 'required',
                      'cvv'   => 'required', 
                      'card'  => 'required',
                      'exp_m' => 'required', 
                  ]);
    if ($validator->fails()) {
        $errorMsg = $validator->messages();
        $arr = [
          'status' => 2,
          'error_msg' => $errorMsg
        ];
        return response()->json($arr,200);
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
          flash("Success, Your Card Added Successfully")->success();
          $arr = [
            'status' => 1,
          ];
          return response()->json($arr,200);
        }else{
          $arr = [
            'status'    => 0,
            'err_msg'   => 'Your Card is Expired'
          ];
          return response()->json($arr,200);
        }
      }else{
        $arr = [
            'status'    => 0,
            'err_msg'   => $result->message
          ];
          return response()->json($arr,200);
      }
    }else{
        $arr = [
          'status'    => 0,
          'err_msg'   => 'Something went wrong'
        ];
        return response()->json($arr,200);
    }
  }

  public function testTransaction(){
    $u_token = Auth::user()->paymentCreditCard('credit_card')->first();

    $card_check = Braintree_CreditCard::find($u_token->credit_card_token);
    // dd($card_check->expired);
    $t_1000 = Braintree_Transaction::sale(array('amount' => '80.00', 'paymentMethodToken' => $u_token->credit_card_token,'options' => [
                                     'submitForSettlement' => True,
                                       ]));
    // dd($t_1000->message);
  }
}
