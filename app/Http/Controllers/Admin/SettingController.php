<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Setting;

class SettingController extends Controller
{
    public function paypal(){
    	$paypal = Setting::where('key','paypal_fee')->first();
    	return view('admin.settings.paypal',compact('paypal'));
    }
    public function savePaypal(Request $request){
    	$this->validate($request, [
            'paypal_fee' => 'required', 
            'title' => 'required', 
        ]);
        $setting = Setting::where('key','paypal_fee')->first();
        $setting->title = request()->title;
        $setting->value = request()->paypal_fee;
        $is_updated = $setting->save();
        if($is_updated){
        	flash('Success, Record Updated Successfully.')->success();
        	return redirect()->back();
        }
    }
    public function shipmentFee(){
        $shipment = Setting::where('key','shipment_fee')->first();
        return view('admin.settings.shipment',compact('shipment'));
    }
    public function shipmentFeeSave(Request $request){
        $this->validate($request, [
            'shipment_fee' => 'required', 
            'title' => 'required', 
        ]);
        $setting = Setting::where('key','shipment_fee')->first();
        $setting->title = request()->title;
        $setting->value = request()->shipment_fee;
        $is_updated = $setting->save();
        if($is_updated){
            flash('Success, Record Updated Successfully.')->success();
            return redirect()->back();
        }
    }
}
