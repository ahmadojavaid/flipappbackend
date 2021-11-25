<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\ProductBid;
use App\Http\Models\ProductSale;
use App\Http\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Chat;
use App\Http\Models\ChatMessage;
use Auth;

class BuyingController extends ApiController
{
    public function getallProducts(){
        $product_sales = ProductSale::where('buyer_id',Auth::user()->id)
            ->where(function($qry){
                $qry->where('product_status','pending')
                    ->orWhere('product_status','delivered')
                    ->orWhere('product_status','denied');
            })
            ->with('product.productImage','productSize.productTypeSize')
            ->orderBy('product_sales.created_at','desc')
        ->get();
        $arr = [
            'productSale' => $product_sales
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'All Bids Fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    
    public function getReviews(){
        
         $product_sale = ProductSale::join('users as u','u.id','product_sales.buyer_id')
         ->where('buyer_id', Auth::user()->id)
            ->where(function($qry){
                $qry->Where('product_status','delivered');
            })
            ->selectRaw('review,subject,overall_rating,u.user_name,product_sales.created_at')
            
            ->orderBy('product_sales.created_at','desc')
        ->get();
        // $arr = [
        //     'Reviews' => $product_sale
        // ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'All Reviews Fetched Successfully';
        $this->apiHelper->result 		 = $product_sale;
        return response()->json($this->apiHelper->responseParse(),200);
        
    }

//     public function rateSeller(Request $request,$id){
        
//         // dd($request->all());
        

// //        dd($request->all());
        
//         $product_sale = ProductSale::where('id',$id)->first();
        

// //        dd($product_sale);
//         if($product_sale){
//             $product_sale->product_status 		= 'received';
//             $product_sale->overall_rating		= request()->overall_rating;
//             $product_sale->subject 		= request()->subject;
//             $product_sale->review 		= request()->review;
//             $is_saved = $product_sale->save();

//             if($is_saved){
//                 $arr = [
//                     'status' => 1,
//                     'rating'=>$product_sale

//                 ];
//             }else{
//                 $arr = [
//                     'status' => 0,
//                     'rating'=>$product_sale
//                 ];
//             }
//         }else{
//             $arr = [
//                 'status' => 0,
//             ];
//         }
//         $this->apiHelper->statusCode     = 1;
//         $this->apiHelper->statusMessage  = 'All reviews save Successfully';
//         $this->apiHelper->result 		 = $arr;
//         return response()->json($this->apiHelper->responseParse(),200);
//     }

    public function getBuyProducts()
    {
        $product_sales = ProductSale::where('buyer_id', Auth::user()->id)
            ->where(function ($qry) {
                $qry->where('product_status', 'pending')
                    ->orWhere('product_status', 'delivered')
                    ->orWhere('product_status', 'denied');
            })
            ->with('product.productImage', 'productSize.productTypeSize')
            ->orderBy('product_sales.created_at', 'desc')->get();

        $arr = [
            'buyproduct' => $product_sales
        ];
        $this->apiHelper->statusCode = 1;
        $this->apiHelper->statusMessage = 'All buy Product Fetched Successfully';
        $this->apiHelper->result = $arr;
        return response()->json($this->apiHelper->responseParse(), 200);

    }

    public function getBuyProductsHistory()
    {

        $product_sales = ProductSale::where('buyer_id', Auth::user()->id)
            ->where('product_status', 'received')
            ->with('product.productImage', 'productSize.productTypeSize')
            ->orderBy('product_sales.created_at', 'desc')->get();

        $arr = [
            'productSale' => $product_sales
        ];
        $this->apiHelper->statusCode = 1;
        $this->apiHelper->statusMessage = 'All buy Product history Fetched Successfully';
        $this->apiHelper->result = $arr;
        return response()->json($this->apiHelper->responseParse(), 200);

    }

    public function productBuydetail(Request $request,$id){
//        dd('hello');

        if($request->buyer_id){

            $sender_id=Auth::user()->id;
            $conversation=Chat::where(function($q) use ($request,$sender_id) {
                $q->where(function($query) use ($request,$sender_id){
                    $query->where('participant_1_id', $sender_id)
                        ->where('participant_2_id', $request->buyer_id);
                })
                    ->orWhere(function($query) use ($request,$sender_id) {
                        $query->where('participant_1_id', $request->buyer_id)
                            ->where('participant_2_id', $sender_id);
                    });
            })->first();

            if(!$conversation){

                $response = [
                    'success' => false,
                    'messages' => ChatMessage::where('chat_id',isset($conversation) ? $conversation->id : $request->chat_id)
                        ->orderBy('created_at', 'desc')
                        ->offset($request->offset)
                        ->take(20)
                        ->get()

            ];

                return response()->json([$response]);


            }

        }
            

        $product_sale = ProductSale::where('id',$id)->with('product','seller','productSize.productTypeSize','product.productImage')->first();
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
        $this->apiHelper->statusMessage  = 'Product detail fetched Successfully';
        $this->apiHelper->result 		 = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    
     public function receiveProduct($id){
         $product_sale = ProductSale::find($id);
         
        //  dd($product_sale);
    	if($product_sale){
    	    
    		if($product_sale->product_status = 'delivered'){
    			$product_sale->product_status = 'received';
	    		$is_saved = $product_sale->save();
	    		
	   // 		dd($is_saved);
	    		if($is_saved){
	    		 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Product ';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
	    		}else{
	    			 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = ' detail';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
	    		}
    		}else{
    		 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = ' fetched';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
    		}
    	}else{
    		 $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = ' Successfully';
         $this->apiHelper->result 		 = $product_sale;
         return response()->json($this->apiHelper->responseParse(),200);
    	}
     }
    
    
  


    }
