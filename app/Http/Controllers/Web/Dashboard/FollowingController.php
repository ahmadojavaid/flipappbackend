<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\FollowingProduct;
use DataTables,Auth;
use App\Http\Models\ProductAsk;

class FollowingController extends Controller
{
    public function index(){
    	return view('web.dashboard.following.index');
    }
    public function getFollowingProduct(){
    	$productFollowings = FollowingProduct::where('user_id',Auth::user()->id)->with('product','productSize')->orderBy('following_products.created_at','desc');
    	// dd($productFollowings);
    	return DataTables::of($productFollowings)
			->editColumn('product.product_name',function($following){
				 return '<div class="d-flex flex-row justify-content-start">
										<div class="p-1">
											<img src="'.asset('').$following->product->productImage->image_url.'"
												style="width: 60px;height: 60px;object-fit: cover;">
										</div>
										<div class="p-1">
											<div class="d-flex flex-column justify-content-between">
												<div>
													<p class="mb-0 font-weight-bold">'.$following->product->product_name.'</p>
												</div>
												<div class="d-flex flex-row justify-content-between">
													<div>
														<p class="mb-0 d-inline">Size:</p>
														<p class="mb-0 d-inline font-weight-bold pl-2">'.@$following->productSize->productTypeSize->name.'</p>
													</div>
													<div>
														<a class="text-decoration-none" href="javascript:void(0)" id="remove" data-href="'.route('seller.following.delete',$following->id).'" style="color: #EA2126">Remove <i
															   class="fas fa-trash-alt pl-1"></i></a>
													</div>

												</div>

											</div>
										</div>
									</div>';
				 // .'<br> Condition : '.$following->->condition;
			})
			->editColumn('productSize.retail_price',function($following){
				 return $following->productSize->retail_price;
			})
			->addColumn('lowest_ask',function($following){
				 if($following->product){
				 	$product_ask = ProductAsk::where('product_id',$following->product_id)
				 								->where('product_size_id',$following->product_size_id)
				 								->min('ask');
				 	if($product_ask){
				 		return $product_ask;
				 	}
				 }
			})
			->rawColumns(['product.product_name', 'action','coupon'])
			->make(true);
    }
    public function save(){
    	$p_id = request()->product_id;
    	$s_id = request()->size_id;
    	$following = FollowingProduct::where('product_id',$p_id)
    								  ->where('product_size_id',$s_id)
    								  ->where('user_id',Auth::user()->id)
    								  ->first();
    	if($following){
    		flash("Error, You already added in following list")->error();
	        return redirect()->route('seller.following.index');
    	}else{
    		$product_following = new FollowingProduct();
	    	$product_following->product_id = $p_id;
	    	$product_following->product_size_id = $s_id;
	    	$product_following->user_id = Auth::user()->id;
	    	$is_saved = $product_following->save();
	    	if($is_saved){
	    		flash("Success, Following Successfully Done...")->success();
	            return redirect()->route('seller.following.index');
	    	}else{
	    		flash("Error, Something went wrong...")->error();
	            return redirect()->route('seller.following.index');
	    	}
    	}
    }

    public function delete($id){
    	$following = FollowingProduct::where('id',$id)->first();
    	if($following){
    		$following->delete();
	    	flash("Success, Following Deleted Successfully")->success();
	    	return redirect()->back();
    	}else{
    		flash("Error, Something went wrong...")->error();
	        return redirect()->back();
    	}
    }
}
