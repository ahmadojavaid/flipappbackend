<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Country;
use App\Http\Models\PaymentMethod;
class SettingController extends Controller
{
    public function index(){
    	$payment_methods = PaymentMethod::all();
    	$countries = Country::where('status','active')->get();
    	return view('web.dashboard.settings.index',compact('countries','payment_methods'));
    }
    public function deliveryAddress(){
    	$countries = Country::where('status','active')->get();
    	return view('web.dashboard.settings.delivery_address',compact('countries'));
    }
}
