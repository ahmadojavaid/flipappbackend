<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use App\Http\Models\UserDeliveryAddress;
class ProfileController extends Controller
{
    public function index(){
    	return view('web.dashboard.profile.index');
    }

    public function changePassword(Request $request){
    	$this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed', 
        ]);

        if(Hash::check(request()->old_password, auth()->user()->password)){
        	$is_updated = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
        	if($is_updated){

        		 flash('Success!, Your password has been changed.')->success();
				return redirect()->back();
        	}else{
        		// flash('Sorry! Something Went Wrong')->error();
        		$errors = [
        			[
        				'er1' => 'Sorry!, Your password has been changed'
        			]
        		];
				return redirect()->back()->withErrors($errors);
        	}
        }else{
			// flash('Sorry! Your old password is wrong')->error();
			$errors = [
        			[
        				'er2' => 'Sorry!, Your old password is wrong'
        			]
        		];
			return redirect()->back()->withErrors($errors);
        }
    }

    public function edit(){
    	return view('web.dashboard.profile.edit-profile');
    }
    public function update(Request $request){
    	$this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_name' => 'required',
            'phone_number' => 'required',
            'country' => 'required', 
            'email' => 'email|required|unique:users,email,'.Auth::user()->id,
        ]);
        $user  = User::find(Auth::user()->id);
        $user->first_name = request()->first_name;
        $user->last_name  = request()->last_name;
        $user->user_name  = request()->user_name;
        $user->phone_number = request()->phone_number;
        $user->country   = request()->country;
        $user->email = request()->email;
        $is_updated = $user->update();
        if($is_updated){
        	flash('Success!, Your Profile has been updated.')->success();
			return redirect()->route('seller.profile.index');
        }else{
        	flash('Error!, Something went wrong.')->error();
			return redirect()->back();
        }
    }
    public function deliveryAddress(Request $request){
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);
        if(empty(request()->url)){
            request()->merge(['address' => '']);
            $this->validate($request, [
                'address' => 'required',
            ]);
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
                flash('Success!, Record Saved Successfully.')->success();
                return redirect()->route('seller.setting.index');
            }else{
                flash('Error!, Something Went Wrong.')->error();
                return redirect()->back();
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
                flash('Success!, Record Saved Successfully.')->success();
                return redirect()->route('seller.setting.index');
            }else{
                flash('Error!, Something Went Wrong.')->error();
                return redirect()->back();
            }
        }

    }
    public function deliveryAddressCheckout(Request $request){
        // dd(request()->all());
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);
        if(empty(request()->url)){
            request()->merge(['address' => '']);
            $this->validate($request, [
                'address' => 'required',
            ]);
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
                flash('Success!, Record Saved Successfully.')->success();
                return redirect()->back();
            }else{
                flash('Error!, Something Went Wrong.')->error();
                return redirect()->back();
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
                flash('Success!, Record Saved Successfully.')->success();
                return redirect()->back();
            }else{
                flash('Error!, Something Went Wrong.')->error();
                return redirect()->back();
            }
        }

    }

    
}
