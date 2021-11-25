<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\Product;  
use App\Http\Models\FollowingProduct; 
use Auth;

class FollowingController extends ApiController
{
    public function searchProduct(Request $request){
    	$validator = Validator::make($request->all(), [
            'search' =>	'required',
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	$search = request()->search; 
		$products = Product::where('product_name','like','%'.$search.'%')
						->where('product_status',1)
                        ->limit(15)
						->with('productImage','ProductSizes.productTypeSize')
						->get();
    	if(count($products) > 0){
    		$arr = [
				'products' => $products,
			];
			$this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Products fetched Successfully';
            $this->apiHelper->result         = $arr;
            return response()->json($this->apiHelper->responseParse(),200);
    	}else{
    		$this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'No Product Found';
            return response()->json($this->apiHelper->responseParse(),422);
    	}
    }

    public function saveProductFollowing(Request $request){
    	$validator = Validator::make($request->all(), [
            'product_id' =>	'required',
            'size_id'    =>	'required',
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
    	$p_id = request()->product_id;
    	$s_id = request()->size_id;
    	$following = FollowingProduct::where('product_id',$p_id)
    								  ->where('product_size_id',$s_id)
    								  ->where('user_id',Auth::user()->id)
    								  ->first();
    	if($following){
	        $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'You have already added in following list';
            return response()->json($this->apiHelper->responseParse(),422);
    	}else{
    		$product_following = new FollowingProduct();
	    	$product_following->product_id = $p_id;
	    	$product_following->product_size_id = $s_id;
	    	$product_following->user_id = Auth::user()->id;
	    	$is_saved = $product_following->save();
	    	if($is_saved){
	    		$arr = [
	    			'productFollowing'	=>	$product_following
	    		];
	            $this->apiHelper->statusCode     = 1;
	            $this->apiHelper->statusMessage  = 'Following Successfully Done';
	            $this->apiHelper->result 		 = $arr;
	            return response()->json($this->apiHelper->responseParse(),200);
	    	}else{
	            $this->apiHelper->statusCode     = 0;
	            $this->apiHelper->statusMessage  = 'Something went wrong';
	            return response()->json($this->apiHelper->responseParse(),422);
	    	}
    	}
    }

    public function deleteProductFollowing(Request $request){
    	$validator = Validator::make($request->all(), [
            'following_id'   =>	'required',
        ]);
		if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }
        $id = request()->following_id;
    	$following = FollowingProduct::where('id',$id)->first();
    	if($following){
    		$following->delete();
	    	$this->apiHelper->statusCode     = 1;
            $this->apiHelper->statusMessage  = 'Product Following Deleted Successfully';
            return response()->json($this->apiHelper->responseParse(),200);
    	}else{
	        $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Something went wrong';
            return response()->json($this->apiHelper->responseParse(),422);
    	}
    }
    public function getProductFollowing(Request $request){
    	$productFollowings = FollowingProduct::where('user_id',Auth::user()->id)
    										->with('product.productImage','product.singleLowestAsk','productSize.productTypeSize')
    										->orderBy('following_products.created_at','desc')
    										->paginate(config('constants.paginate_per_page'));
    	$arr = [
    		'productFollowings' => $productFollowings
    	];
    	$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Following Products fetched Successfully';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
}
