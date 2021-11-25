<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables,Helper;
use App\Http\Models\Product;
use App\Http\Models\ProductSize;
use App\Http\Models\ProductType;
use App\Http\Models\ProductAsk;
use App\Http\Models\ProductBid;
use App\Http\Models\ProductTypeSize;
use App\Http\Models\ProductImage;
use App\Http\Models\Brand;

class ProductBidsAskController extends Controller
{
	public function productBySize(){
		return view('admin.product_by_size.product_by_size');
	}

	public function getProductBySize(){
    	$products 	= ProductSize::with('product.brandName','productTypeSize')->whereHas('product',function($qry){
    		$qry->where('product_status',1);
    	})->where('status','active')->orderBy('product_id','desc')->get();
         // dd($products);
		return DataTables::of($products)
			->editColumn('productTypeSize.name',function($product){
				if($product){
							return '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">'.$product->productTypeSize->name.'</div>';
				}
			})

			->rawColumns(['status', 'action', 'productTypeSize.name'])
			->addColumn('action',function($product){
				return view('admin.product_by_size.action-button',compact('product'))->render();
			})->make(true);
	}

	public function productBySizeAsks(){
		return view('admin.product_by_size.bids_asks.index');
	}
	public function getProductBySizeAsks($id){
    	$product_size 	= ProductSize::where('id',$id)->first();
    	// dd($product_size);
    	$product_id = $product_size->product_id;
    	$productAsks = ProductAsk::where('product_id',$product_id)->where('product_size_id',$product_size->id)->with('user')->orderBy('product_asks.created_at','desc')->get();
//    	dd($productAsks);
    	return DataTables::of($productAsks)
			->addColumn('bid',function(){
				return '';
			})
			->addColumn('coupon',function(){
				return '';
			})
			->editColumn('status',function($product_ask){
				return $product_ask->ask_status;
			})
			->rawColumns(['status', 'action', 'productTypeSize.name'])
			->addColumn('action',function($product){
				return view('admin.product_by_size.action-button',compact('product'))->render();
			})->make(true);
	}

	public function getProductBySizeBids($id){
    	$product_size 	= ProductSize::where('id',$id)->first();
    	$product_id = $product_size->product_id;
    	$productAsks = ProductBid::where('product_id',$product_id)->where('product_size_id',$product_size->id)->with('user','couponBid.coupon')->orderBy('product_bids.created_at','desc');
    	return DataTables::of($productAsks)
			->addColumn('ask',function(){
				return '';
			})
			->editColumn('status',function($product_bid){
				// return $product_bid->bid_status;
				if($product_bid){
					if($product_bid->bid_status == 'active'){
						return '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">'.$product_bid->bid_status.'</div>';
					}elseif($product_bid->bid_status == 'buy'){
						return '<div class="badge bg-soft-info text-info mb-3 shadow-none m-r-5">Sell</div>';
					}else{
						return '<div class="badge bg-soft-danger text-danger mb-3 shadow-none m-r-5">'.$product_bid->bid_status.'</div>';
					}
				}
			})
			->editColumn('coupon',function($product_bid){
				if($product_bid){
					if($product_bid->couponBid){
						// return $product_bid->couponBid->coupon->name;
						return '<p class="text-muted mb-0">Coupon Name: <b>'.$product_bid->couponBid->coupon->name.'</b> <span class="float-right"></p>
								<p class="text-muted mb-0">Coupon Code: <b>'.$product_bid->couponBid->coupon->code.'</b> <span class="float-right"></p>
								<p class="text-muted mb-0">Coupon Amount:<b>£ '.$product_bid->couponBid->coupon->discount_amount.' </b><span class="float-right"></p>';
					}
				}
			})
			->rawColumns(['status', 'action','coupon'])
			->make(true);
	}


}
