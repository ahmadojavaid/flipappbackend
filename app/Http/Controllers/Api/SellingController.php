<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\ProductSale;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\Setting;
use Auth;

class SellingController extends ApiController
        {
        public function getSaleProducts(){
        $product_sales = ProductSale::where('seller_id',Auth::user()->id)
        								->where(function($qry){
        									$qry->where('product_status','pending')
        										->orWhere('product_status','delivered')
        										->orWhere('product_status','denied');
        								})
        								->with('product.productImage','productSize.productTypeSize')->orderBy('product_sales.created_at','desc')->get();
        								
        								$arr = [
            'productSale'	=> $product_sales,
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Sale Products Fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
        								
        }
     
     public function getSaleProductsHistory(){
    	$product_sales = ProductSale::where('seller_id',Auth::user()->id)
    								->where('product_status','received')
    								->with('product.productImage','productSize.productTypeSize')
    								->orderBy('product_sales.created_at','desc')->get();
    								
    								$arr = [
            'productSale'	=> $product_sales,
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Sale Products Fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    								
}

 public function SaleDetail($id){
        
        // $setting = Setting::where('key','paypal_fee')->first();
        $product_sale = ProductSale::where('id',$id)->with('product','productSize.productTypeSize','product.productImage')->first();
        if($product_sale){
            $arr = [
                'status' => 1,
                'rating'=>$product_sale
            ];

        }else{
            $arr = [
                'status' => 0,
                'rating'=>$product_sale
            ];

        }
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product detail detched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    
     public function deliverProduct($id){
    	$product_sale = ProductSale::find($id);
    	if($product_sale){
    		$product_sale->product_status = 'delivered';
    		$is_saved = $product_sale->save();
    		
    // 		dd($is_saved);
    		if($is_saved){
    			 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product ';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
    		}else{
    			 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product ';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
    		}
    	}else{
    	 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product ';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
    	}
    }
    
    
}
