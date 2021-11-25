<?php

namespace App\Http\Controllers\Web\Homepage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use App\Role;
use Auth;

class SocialController extends Controller
{
    public function redirectFacebook(){
	    return Socialite::driver('facebook')->redirect();
	}
	public function facebookCallback(){
		if(request()->error != 'access_denied'){
			$facebook_obj = Socialite::driver('facebook')->user();
		    if($facebook_obj){
		    	$user_f = User::where('provider_id',$facebook_obj->id)->first();
		    	if($user_f){
		    		$is_loggedIn = Auth::loginUsingId($user_f->id);
		    		return redirect()->route('seller.dashboard');
		    		exit;
		    	}
		    	$user_obj = new User();
			    $user_obj->provider = 'facebook';
			    $user_obj->provider_id = $facebook_obj->id;
			    $user_obj->email_verified_at = date('Y-m-d H:i:s');
			    $user_saved = $user_obj->save();
		        $role_seller = Role::where('name','seller')->first();
		        $role_buyer = Role::where('name','buyer')->first();
		        if($role_seller->count() > 0 && $role_buyer->count() > 0){
		            $user_obj->roles()->attach($role_seller->id);
		            $user_obj->roles()->attach($role_buyer->id);
		        }
		        $is_loggedIn = Auth::loginUsingId($user_obj->id);
			   if($is_loggedIn){ 
			   		return redirect()->route('seller.dashboard');
			   }else{
			   		flash('Sorry! Something Went Wrong...')->error();
			   		return redirect()->route('frontend_login');
			   }
		    }else{
		    	flash('Sorry! Something Went Wrong...')->error();
		    	return redirect()->route('frontend_login');
		    }
		}else{
		    flash('Please Authorized for SignUp.')->error();
		    return redirect()->route('frontend_login');
		}
	}

	 public function redirectTwitter(){
	    return Socialite::driver('twitter')->redirect();
	}
	public function twitterCallback(){
		if(empty(request()->denied)){
			$twitter_obj = Socialite::driver('twitter')->user();
		    if($twitter_obj){
		    	$user_f = User::where('provider_id',$twitter_obj->id)->first();
		    	if($user_f){
		    		$is_loggedIn = Auth::loginUsingId($user_f->id);
		    		return redirect()->route('seller.dashboard');
		    		exit;
		    	}
		    	$user_obj = new User();
		    	if($twitter_obj->name){
		    		$user_obj->first_name = $twitter_obj->name;
		    	}
		    	$user_obj->email      = $twitter_obj->email;
			    $user_obj->provider = 'twitter';
			    $user_obj->provider_id = $twitter_obj->id;
			    $user_obj->email_verified_at = date('Y-m-d H:i:s');
			    $user_saved = $user_obj->save();
		        $role_seller = Role::where('name','seller')->first();
		        $role_buyer = Role::where('name','buyer')->first();
		        if($role_seller->count() > 0 && $role_buyer->count() > 0){
		            $user_obj->roles()->attach($role_seller->id);
		            $user_obj->roles()->attach($role_buyer->id);
		        }
		        $is_loggedIn = Auth::loginUsingId($user_obj->id);
			   if($is_loggedIn){ 
			   		return redirect()->route('seller.dashboard');
			   }else{
			   		flash('Sorry! Something Went Wrong...')->error();
			   		return redirect()->route('frontend_login');
			   }
		    }else{
		    	flash('Sorry! Something Went Wrong...')->error();
		    	return redirect()->route('frontend_login');
		    }
		}else{
		    flash('Please Authorized for SignUp.')->error();
		    return redirect()->route('frontend_login');
		}
	}
}
