<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Helpers\APIHELPER;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\UserDeliveryAddress;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class SettingController extends ApiController
{
    public function getDeliveryAddress(){
        $user = UserDeliveryAddress::where('user_id',Auth::user()->id)->first();
        if($user){
           $arr = [
            'deliveryAddress' => $user,
           ];
            $this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Delivery Address!';
            $this->apiHelper->result         = $arr;
            return response()->json($this->apiHelper->responseParse(),200);
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'No Delivery Address Found!';
            // $this->apiHelper->result         = $arr;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        
    }
    public function deliveryAddress(Request $request){
    	$validator = Validator::make($request->all(), [
			            'first_name' 	=> 'required',
			            'last_name' 	=> 'required',
			            'postal_code' 	=> 'required',
			            'country' 		=> 'required',
			            'address' 		=> 'required',
			            'url'			=> 'required'
			        ]);
    	if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $user_deliver_address = UserDeliveryAddress::where('user_id',Auth::user()->id)->first();
        if($user_deliver_address){
            $user_deliver_address->first_name = request()->first_name;
            $user_deliver_address->last_name = request()->last_name;
            $user_deliver_address->country_id = request()->country;
            $user_deliver_address->address = request()->address;
            $user_deliver_address->location_url = request()->url;
            $user_deliver_address->postal_code = request()->postal_code;
            $is_update = $user_deliver_address->update();
            if($is_update){
            	$user_deliver_address = UserDeliveryAddress::where('id',$user_deliver_address->id)->with('country')->first();
            	$arr = [
            		'deliveryAddress' => $user_deliver_address,
            	];
                $this->apiHelper->statusCode     = 1;
	            $this->apiHelper->statusMessage  = 'Delivery Address Saved Successfully';
	            $this->apiHelper->result         = $arr;
	            return response()->json($this->apiHelper->responseParse(),200);
            }else{
                $this->apiHelper->statusCode     = 0;
	            $this->apiHelper->statusMessage  = 'Something went wrong';
	            return response()->json($this->apiHelper->responseParse(),422);
            }
        }else{
            $user_deliver_address = new UserDeliveryAddress();
            $user_deliver_address->first_name = request()->first_name;
            $user_deliver_address->last_name = request()->last_name;
            $user_deliver_address->country_id = request()->country;
            $user_deliver_address->address = request()->address;
            $user_deliver_address->location_url = request()->url;
            $user_deliver_address->user_id = Auth::user()->id;
            $user_deliver_address->postal_code = request()->postal_code;
            $is_saved = $user_deliver_address->save();
            if($is_saved){
            	$user_deliver_address = UserDeliveryAddress::where('id',$user_deliver_address->id)->with('country')->first();
                $arr = [
            		'deliveryAddress' => $user_deliver_address,
            	];
                $this->apiHelper->statusCode     = 1;
	            $this->apiHelper->statusMessage  = 'Delivery Address Saved Successfully';
	            $this->apiHelper->result         = $arr;
	            return response()->json($this->apiHelper->responseParse(),200);
            }else{
                $this->apiHelper->statusCode     = 0;
	            $this->apiHelper->statusMessage  = 'Something went wrong';
	            return response()->json($this->apiHelper->responseParse(),422);
            }
        }
    }

    public function editProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'user_name'     =>  'required',
            'phone_number'  =>  'required',
            'country'       =>  'required', 
            'email'         =>  'email|required|unique:users,email,'.Auth::user()->id,
        ]);
        if($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $user  = User::find(Auth::user()->id);
        $user->first_name = request()->first_name;
        $user->last_name  = request()->last_name;
        $user->user_name  = request()->user_name;
        $user->phone_number = request()->phone_number;
        $user->country   = request()->country;
        $user->email = request()->email;
        $is_updated = $user->update();
        if($is_updated){
            $arr = [
                'userProfile' => $user,
            ];
            $this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Profile updated Successfully.';
            $this->apiHelper->result         = $arr;
            return response()->json($this->apiHelper->responseParse(),200);
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Something went wrong.';
            return response()->json($this->apiHelper->responseParse(),422);
        }
    }  

    public function passwordChange(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed', 
        ]);
        if($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        if(Hash::check(request()->old_password, auth()->user()->password)){
            $is_updated = User::find(auth()->user()->id)
                                ->update([
                                    'password'=> Hash::make($request->password)
                                ]);
            if($is_updated){
                $this->apiHelper->statusCode     = 1;
                $this->apiHelper->statusMessage  = 'Password Change Successfully.';
                return response()->json($this->apiHelper->responseParse(),200);
            }else{
                $this->apiHelper->statusCode     = 0;
                $this->apiHelper->statusMessage  = 'Something went wrong.';
                return response()->json($this->apiHelper->responseParse(),422);
            }
        }else{
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Old Password is wrong.';
            return response()->json($this->apiHelper->responseParse(),422);
        }
    }  

}
