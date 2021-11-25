<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables,Auth;
use App\Http\Models\ProductSale;
use App\Http\Models\Setting;

class SellingController extends Controller
{
    public function index(){
    	return view('web.dashboard.selling.listing.index');
    }
    public function getSaleProducts(){
    	$product_sales = ProductSale::where('seller_id',Auth::user()->id)
    									->where(function($qry){
    										$qry->where('product_status','pending')
    											->orWhere('product_status','delivered')
    											->orWhere('product_status','denied');
    									})
    									->with('product.productImage','productSize.productTypeSize')->orderBy('product_sales.created_at','desc');
    	return DataTables::of($product_sales)
			->editColumn('product.product_name',function($product_sale){
				 return '<div class="d-flex flex-row justify-content-start">
										<div class="p-1">
											<img src="'.asset('').$product_sale->product->productImage->image_url.'"
												style="width: 60px;height: 60px;object-fit: cover;">
										</div>
										<div class="p-1">
											<div class="d-flex flex-column justify-content-between">
												<div>
													<p class="mb-0 font-weight-bold">'.$product_sale->product->product_name.'</p>
												</div>
													<div>
														<p class="mb-0 d-inline">Size:</p>
														<p class="mb-0 d-inline font-weight-bold pl-2">'.$product_sale->productSize->productTypeSize->name.'</p>
													</div><br>
													<div>
														<p class="mb-0 d-inline">Condition:</p>
														<p class="mb-0 d-inline font-weight-bold pl-2">'.ucfirst($product_sale->condition).'</p>
													</div>
											</div>
										</div>
									</div>';
				 // .'<br> Condition : '.$following->->condition;
			})
			->editColumn('product_status',function($product_sale){
				if($product_sale->product_status == 'pending'){
					return '<span class="badge badge-blue">PENDING</span>';
				}elseif($product_sale->product_status == 'delivered'){
					return '<span class="badge badge-primary">DELIVERED</span>';
				}elseif($product_sale->product_status == 'received'){
					return '<span class="badge badge-success">RECEIVED</span>';
				}elseif($product_sale->product_status == 'denied'){
					return '<span class="badge badge-danger">DENIED</span>';
				}
			})
			->editColumn('payment_status',function($product_sale){
				if($product_sale->payment_status == 'processed'){
                    return '<span class="badge bg-info text-white">Hold</span>';
                }elseif($product_sale->payment_status == 'delivered'){
                    return '<span class="badge bg-success text-white">DELIVERED</span>';
                }
			})
			->editColumn('total_amount',function($product_sale){
				return '<b>£ '.$product_sale->total_amount.'<b>';
			})

			->addColumn('action',function($product_sale){
				 return '<td>
				 			 <a href="javascript:void(0)" data-href="'.route('seller.selling.product_sale_detail',$product_sale->id).'" class="deliver_p" style="color:black">
				 				<i class="fas fa-eye   " aria-hidden="true"> </i>
				 				 </a>
				 		</td>';
			})
			->rawColumns(['product.product_name', 'action','payment_status','product_status','total_amount'])
			->make(true);
    }

    public function getSaleProductsHistory(){
    	$product_sales = ProductSale::where('seller_id',Auth::user()->id)
    								->where('product_status','received')
    								->with('product.productImage','productSize.productTypeSize')
    								->orderBy('product_sales.created_at','desc');
    	return DataTables::of($product_sales)
			->editColumn('product.product_name',function($product_sale){
				 return '<div class="d-flex flex-row justify-content-start">
										<div class="p-1">
											<img src="'.asset('').$product_sale->product->productImage->image_url.'"
												style="width: 60px;height: 60px;object-fit: cover;">
										</div>
										<div class="p-1">
											<div class="d-flex flex-column justify-content-between">
												<div>
													<p class="mb-0 font-weight-bold">'.$product_sale->product->product_name.'</p>
												</div>
													<div>
														<p class="mb-0 d-inline">Size:</p>
														<p class="mb-0 d-inline font-weight-bold pl-2">'.$product_sale->productSize->productTypeSize->name.'</p>
													</div><br>
													<div>
														<p class="mb-0 d-inline">Condition:</p>
														<p class="mb-0 d-inline font-weight-bold pl-2">'.ucfirst($product_sale->condition).'</p>
													</div>
											</div>
										</div>
									</div>';
				 // .'<br> Condition : '.$following->->condition;
			})
			->editColumn('product_status',function($product_sale){
				if($product_sale->product_status == 'pending'){
					return '<span class="badge badge-blue">PENDING</span>';
				}elseif($product_sale->product_status == 'delivered'){
					return '<span class="badge badge-primary">DELIVERED</span>';
				}elseif($product_sale->product_status == 'received'){
					return '<span class="badge badge-success">RECEIVED</span>';
				}elseif($product_sale->product_status == 'denied'){
					return '<span class="badge badge-danger">DENIED</span>';
				}
			})
			->editColumn('payment_status',function($product_sale){
				if($product_sale->payment_status == 'processed'){
                    return '<span class="badge bg-info text-white">Hold</span>';
                }elseif($product_sale->payment_status == 'delivered'){
                    return '<span class="badge bg-success text-white">DELIVERED</span>';
                }
			})
			->editColumn('total_amount',function($product_sale){
				return '<b>£ '.$product_sale->total_amount.'<b>';
			})

			->addColumn('action',function($product_sale){
				 return '<td>
			 			  <a href="javascript:void(0)" data-href="'.route('seller.selling.product_sale_detail',$product_sale->id).'" class="deliver_p" style="color:black">
			 				<i class="fas fa-eye   " aria-hidden="true"> </i>
			 				 </a>
				 		</td>';
			})
			->rawColumns(['product.product_name', 'action','payment_status','product_status','total_amount'])
			->make(true);
    }



    public function deliverProduct($id){
    	$product_sale = ProductSale::find($id);
    	if($product_sale){
    		$product_sale->product_status = 'delivered';
    		$is_saved = $product_sale->save();
    		if($is_saved){
    			flash('Record Update Successfully')->success();
    			return redirect()->back();
    		}else{
    			flash('Some thing went wrong')->error();
    			return redirect()->back();
    		}
    	}else{
    		flash('Something went wrong')->success();
    		return redirect()->back();
    	}
    }

    public function productSaleDetail($id){
    	$setting = Setting::where('key','paypal_fee')->first();
    	$product_sale = ProductSale::where('id',$id)->with('product','productSize.productTypeSize','product.productImage')->first();
    	if($product_sale){
    		return view('web.dashboard.selling.listing.product-detail',compact('product_sale','setting'));
    	}else{
    		return redirect()->back();
    	}
    }
    public function transaction(){
    	return view('web.dashboard.transaction.index');
    }
}
