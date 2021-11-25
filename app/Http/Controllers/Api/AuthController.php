<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;   
use App\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCode;
use App\Http\Models\VerificationCode as VerificationModel;
use App\Helpers\APIHELPER;

class AuthController extends Controller
{
    public $apiHelper;
    public function __construct(){
        $this->apiHelper = new APIHELPER();
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'phone_number' => 'required',
            'country' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
         

        // $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $request['password'] = Hash::make($request['password']);
        $is_created = User::create($request->except(['password_confirmation']));
        $role_seller = Role::where('name','seller')->first();
        $role_buyer = Role::where('name','buyer')->first();
        $code = rand(447755,88996655);
        if($role_seller->count() > 0 && $role_buyer->count() > 0){
            $verification = new VerificationModel();
            $verification->code = $code;
            $verification->user_id = $is_created->id;
            $verification->save();
            Mail::to(request()->email)->send(new VerificationCode($is_created,$code));
            $is_created->roles()->attach($role_seller->id);
            $is_created->roles()->attach($role_buyer->id);
        }
        if($is_created){
            $is_loggedIn = Auth::loginUsingId($is_created->id);
            if($is_loggedIn){
                $token = Auth::user()->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                            'token' => $token,
                            'user'  => Auth::user(),
                            'code'  => $code
                        ];
                $this->apiHelper->statusCode     = 1;
                $this->apiHelper->statusMessage  = 'We have Send the Verification code';
                $this->apiHelper->result         = $response;
                return response()->json($this->apiHelper->responseParse(),200);
            }else{
                $this->apiHelper->statusCode     = 0;
                $this->apiHelper->statusMessage  = 'Something went wrong';
                return response()->json($this->apiHelper->responseParse(), 400);
            }
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Something went wrong';
            return response()->json($this->apiHelper->responseParse(), 400);
        }

    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'         => 'required',
            'password'      => 'required',
            'fcm_token'     => 'required',
            'device_type'   => 'required',
            'timezone'      => 'required',
        ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                Auth::user()->fcm_id     = request()->fcm_token;
                Auth::user()->device_type   = request()->device_type;
                Auth::user()->timezone      = request()->timezone;
                Auth::user()->save();
                $token          = Auth::user()->createToken('Laravel Password Grant Client')->accessToken;
                $response       = [
                                    'token' => $token,
                                    'user'  => Auth::user()
                                ];
                $this->apiHelper->statusCode     = 1;
                $this->apiHelper->statusMessage  = 'Login Successful';
                $this->apiHelper->result         = $response;
                return response()->json($this->apiHelper->responseParse(), 200);
        }else {
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Login Credential Wrong';
            return response()->json($this->apiHelper->responseParse(), 422);
        }
    }

    public function emailVerification(Request $request){
        
        // dd('hello');
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $code = request()->code;
        $verificationCodeObj = VerificationModel::where('code',$code)->first();
        if($verificationCodeObj){
            if($verificationCodeObj->status == 'active'){
                $user_id = $verificationCodeObj->user_id;
                $verificationCodeObj->status = 'inactive';
                $is_saved = $verificationCodeObj->save();
                if($is_saved){
                    $user = User::where('id',$user_id)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
                    VerificationModel::where('user_id',$user_id)->update(['status'=>'inactive']);
                    $arr = [
                            'user' => Auth::user()
                        ];
                    $this->apiHelper->statusCode     = 1;
                    $this->apiHelper->statusMessage  = 'Email Verified successfully';
                    $this->apiHelper->result         = $arr;
                    return response()->json($this->apiHelper->responseParse(), 200);
                }
            }else{
                $this->apiHelper->statusCode     = 0;
                $this->apiHelper->statusMessage  = 'Sorry! Your token has been expired';
                return response()->json($this->apiHelper->responseParse(), 422);
            }  
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Verification Code is Invalid';
            // $this->apiHelper->result         = $response;
            return response()->json($this->apiHelper->responseParse(), 422);
        }
    }
    public function resendVerificationEmail(){
        $user_obj = Auth::user();
        VerificationModel::where('user_id',Auth::user()->id)->update(['status' => 'inactive']);
        $code = rand(447755,88996655);
        $verification = new VerificationModel();
        $verification->code = $code;
        $verification->user_id = Auth::user()->id;
        $verification->save();
        Mail::to($user_obj->email)->send(new VerificationCode($user_obj,$code));
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'We have send the Verification Code. please check your Email';
        return response()->json($this->apiHelper->responseParse(), 200);
    }
    public function sendPasswordEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $user = User::where('email',request()->email)->first();
        if($user){
            VerificationModel::where('user_id',$user->id)->update(['status' => 'inactive']);
            $code = rand(447755,88996655);
            $verification = new VerificationModel();
            $verification->code = $code;
            $verification->user_id = $user->id;
            $verification->save();
            Mail::to($user->email)->send(new VerificationCode($user,$code,1));
            $this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'We have send the Verification Code. please check your Email';
            return response()->json($this->apiHelper->responseParse(), 200);
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'User does not exists';
            return response()->json($this->apiHelper->responseParse(), 422);
        }
    }
    public function passwordEmailVerification(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $code = request()->code;
        $verificationCodeObj = VerificationModel::where('code',$code)->first();
        if($verificationCodeObj){
            if($verificationCodeObj->status == 'active'){
                $user_id = $verificationCodeObj->user_id;
                $verificationCodeObj->status = 'inactive';
                $is_saved = $verificationCodeObj->save();
                if($is_saved){
                    $user = User::where('id',$user_id)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
                    VerificationModel::where('user_id',$user_id)->update(['status'=>'inactive']);
                    $arr = [
                            'user' => $user
                        ];
                    $this->apiHelper->statusCode     = 1;
                    $this->apiHelper->statusMessage  = 'Code Verified successfully';
                    $this->apiHelper->result         = $arr;
                    return response()->json($this->apiHelper->responseParse(), 200);
                }
            }else{
                $this->apiHelper->statusCode     = 0;
                $this->apiHelper->statusMessage  = 'Sorry! Your token has been expired';
                return response()->json($this->apiHelper->responseParse(), 422);
            }  
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Verification Code is Invalid';
            // $this->apiHelper->result         = $response;
            return response()->json($this->apiHelper->responseParse(), 422);
        }
    }
    public function passwordReset(Request $request){
        $validator = Validator::make($request->all(), [
            'newpassword' => 'required|confirmed',
            'email'     => 'required'
        ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $user = User::where('email',request()->email)->first();
        if($user){
            $new_password = Hash::make(request()->newpassword);
            $user->password = $new_password;
            $user->save();
            $this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Password Reset successfully!';
            return response()->json($this->apiHelper->responseParse(),200); 
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'User Not Exist!';
            return response()->json($this->apiHelper->responseParse(),422); 
        }

    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json(['statusCode' => '0', 'statusMessage' => 'You have been successfully logged out!',
            'Result' => null], 200);
    }

}
