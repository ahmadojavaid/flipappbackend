<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Coupon;
use DataTables;

class CouponController extends Controller
{
    public function index(){
    	return view('admin.coupon.index');
    }
    public function getCoupons(){
    	$coupons 	= Coupon::orderBy('created_at','desc')->get();
		return DataTables::of($coupons)
			->editColumn('coupon_applicable',function($coupon){
				if($coupon){
					return 'All User';
				}
			})

			->rawColumns(['status', 'action', 'product_sizes.size'])
			->addColumn('action',function($coupon){
				return view('admin.coupon.action-buttons',compact('coupon'))->render();
			})->make(true);
    }
    public function create(){
    	return view('admin.coupon.add-coupon');
    }
    public function store(Request $request){
    	$this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons',
            'max_uses' => 'required|regex:/^[1-5]+$/',
            'discount_amount' => 'required',
            'starts_at' => 'required',  
        ]);
    	$ar = explode('-', request()->starts_at);
         
        $coupon = new Coupon();
        $coupon->name = request()->name;
        $coupon->code = request()->code;
        $coupon->max_uses = request()->max_uses;
        $coupon->discount_amount = request()->discount_amount;
        $coupon->starts_at = str_replace('/', '-', trim($ar[0]." ")) ;
	    $coupon->expires_at = str_replace('/', '-', $ar[1]) ; 
        $arr = [
        	'user' => [
        		'scope' => 'all',
        	]
        ];
        $coupon->coupon_applicable = $arr;
        $is_saved = $coupon->save();
        if($is_saved){
        	flash('Success!, Record Saved Successfully.')->success();
        	return redirect()->route('admin.coupon.index');
        }else{
        	flash('Error!, Something Went Wrong.')->error();
        	return redirect()->route('admin.coupon.index');
        }
    }

    public function edit($id){
    	$coupon = Coupon::where('id',$id)->first();
    	if($coupon){
    		return view('admin.coupon.edit-coupon',compact('coupon'));
    	}
    }
    public function update(Request $request){
    	//dd(request()->all());
    	$this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code,'.$request->coupon_id,
            'max_uses' => 'required',
            'discount_amount' => 'required',
            'starts_at' => 'required', 
        ]);
        $ar = explode('-', request()->starts_at);
         
        $coupon = Coupon::where('id',request()->coupon_id)->first();
        if($coupon){
        	$coupon->name = request()->name;
	        $coupon->code = request()->code;
	        $coupon->max_uses = request()->max_uses;
	        $coupon->discount_amount = request()->discount_amount;
	        $coupon->starts_at = str_replace('/', '-', trim($ar[0]." ")) ;
	        $coupon->expires_at = str_replace('/', '-', $ar[1]) ; 
	        $arr = [
	        	'user' => [
	        		'scope' => 'all',
	        	]
	        ];
	        $coupon->coupon_applicable = $arr;
	        $is_saved = $coupon->save();
	        if($is_saved){
	        	flash('Success!, Record Updated Successfully.')->success();
	        	return redirect()->route('admin.coupon.index');
	        }else{
	        	flash('Error!, Something Went Wrong.')->error();
	        	return redirect()->route('admin.coupon.index');
	        }
        }else{
	        	flash('Error!, Coupon Not Exist.')->error();
	        	return redirect()->route('admin.coupon.index');
	        }
        
    }
    public function delete($id){
    	$coupon = Coupon::where('id',$id)->first();
    	if($coupon){
    		$coupon->delete();
    		flash('Success!, Record Deleted Successfully.')->success();
	        return redirect()->route('admin.coupon.index');
    	}else{
    		flash('Error!, Something Went Wrong.')->error();
	        return redirect()->route('admin.coupon.index');
    	}
    }
}
