<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 21-Oct-19
 * Time: 2:54 PM
 */

namespace App\Http\Controllers\Web\Homepage;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Role;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\Mail\VerificationCode;
use App\Http\Models\VerificationCode as VerificationModel;

class AuthController extends Controller
{
    public function register(Request $request){
         $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'phone_number' => 'required',
            'country' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
        ]);
        $request['password'] = Hash::make($request['password']);
        $is_created = User::create($request->except(['password_confirmation']));
//        dd($is_created);
        $role_seller = Role::where('name','seller')->first();
        $role_buyer = Role::where('name','buyer')->first();
        if($role_seller->count() > 0 && $role_buyer->count() > 0){
            $code = rand(447755,88996655);
            $verification = new VerificationModel();
            $verification->code = $code;
            $verification->user_id = $is_created->id;
            $verification->save();
            Mail::to(request()->email)->send(new VerificationCode($is_created,$code));
            $is_created->roles()->attach($role_seller->id);
            $is_created->roles()->attach($role_buyer->id);
        }
        if($is_created){
            Auth::loginUsingId($is_created->id);
            $arr = [
                'status' => 1,
                'message' => 'We have Send the Verification code'
            ];
            return response()->json($arr);
        }else{
            $arr = [
                'status' => 0,
                'message' => 'Something Went Wrong'
            ];
            return response()->json($arr);
        }
       // return redirect('/login');
    }

    public function login(Request $request){
        
      

        if (Auth::attempt(request()->except('_token'))) {
            if(Auth::user()->hasRole('seller')){
                $arr = [
                    'url' => route('seller.dashboard'),
                    'status' => 1
                ];
                return response()->json($arr);
            }elseif(Auth::user()->hasRole('buyer')){
                $arr = [
                    'url' => route('seller.dashboard'),
                    'status' => 1
                ];
                return response()->json($arr);
            }elseif(Auth::user()->hasRole('admin')){
                Auth::logout();
                $arr = [
                    'message' => 'Login Credential is wrong',
                    'status' => 0
                ];
                return response()->json($arr);
            }
        }else{
            $arr = [
                'message' => 'Login Credential is wrong',
                'status' => 0
            ];
            return response()->json($arr);
        }
    }

    public function resendVerificationCode(){
        $user_obj = Auth::user();
        VerificationModel::where('user_id',Auth::user()->id)->update(['status' => 'inactive']);
        $code = rand(447755,88996655);
        $verification = new VerificationModel();
        $verification->code = $code;
        $verification->user_id = Auth::user()->id;
        $verification->save();
        Mail::to($user_obj->email)->send(new VerificationCode($user_obj,$code));
        flash('We have send the Verification Code. please check your Email')->success();
        return redirect()->back();
    }
    // public function forgotPassword(){
    //     return view('web.homepage.forgot-password');
    // }
    // public function postForgotPassword(Request $request){
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //     ]);
    //     $user = User::where('email',request()->email)->first();
    //     if($user){

    //     }else{
    //         flash('Sorry! Email Does Not Exists...')->error();
    //         return redirect()->back();
    //     }

    // }
}
