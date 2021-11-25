<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Http\Models\ProductBid;
use App\Http\Models\ProductAsk;
use App\Http\Models\ProductSale;
use DataTables;

class UserController extends Controller
{
    public function index(){
    	return view('admin.users.index');
    }
    public function getUsers(){
    	$role = Role::where('name','admin')->first();
    	$users 	= User::join('role_user','role_user.user_id','=','users.id')
    					->where('role_user.role_id','!=',$role->id)
    					->groupBy('role_user.user_id')
    					;
		return DataTables::of($users)
			->editColumn('email_verified_at',function($user){
				if(!empty($user->email_verified_at)){
					return '<span class="badge badge-success">Verified</span>';
				}else{
					return '<span class="badge badge-danger ">Not Verified</span>';
				}
			})
			->editColumn('provider',function($user){
				if(!empty($user->provider)){
					return '<span class="badge badge-primary">'.ucfirst($user->provider).'</span>';
				}
			})
			->rawColumns(['email_verified_at', 'action', 'provider'])
			->addColumn('action',function($user){
				return view('admin.users.action-buttons',compact('user'))->render();
			})->make(true);
    }
    public function pageRender($type,$id){
        $user = User::find($id);
        if($type == 'bids_asks'){
            $active_bids = ProductBid::selectRaw('COUNT(product_bids.id) as total')
                                     ->where('bid_status','active')
                                     ->where('user_id',$user->id)
                                     ->first();
            $expire_bids = ProductBid::selectRaw('COUNT(product_bids.id) as total')
                                     ->where('bid_status','inactive')
                                     ->where('user_id',$user->id)
                                     ->first();
            $active_asks = ProductAsk::selectRaw('COUNT(product_asks.id) as total')
                                     ->where('ask_status','active')
                                     ->where('seller_id',$user->id)
                                     ->first();
            $expire_asks = ProductAsk::selectRaw('COUNT(product_asks.id) as total')
                                     ->where('ask_status','inactive')
                                     ->where('seller_id',$user->id)
                                     ->first();
            return view('admin.users.profile.bids_asks',compact('user','active_bids','expire_bids','active_asks','expire_asks'))->render();
        }elseif($type == 'buying_selling'){
            $total_product_sale_buying = ProductSale::selectRaw('COUNT(id) as t_id,SUM(total_amount) as t_amount')->where('buyer_id',$user->id)->first();
            $total_product_sale_sellig = ProductSale::selectRaw('COUNT(id) as t_id,SUM(total_amount) as t_amount')->where('seller_id',$user->id)->first();

             return view('admin.users.profile.buying_selling',compact('user','total_product_sale_buying','total_product_sale_sellig'))->render();
        }
    }
    public function userProfile($id){
    	$user = User::find($id);
    	if($user){
    	// 	$active_bids = ProductBid::selectRaw('COUNT(product_bids.id) as total')
    	// 								->where('bid_status','active')
    	// 								->where('user_id',$user->id)
    	// 								->first();
    	// 	$expire_bids = ProductBid::selectRaw('COUNT(product_bids.id) as total')
    	// 								->where('bid_status','inactive')
    	// 								->where('user_id',$user->id)
    	// 								->first();
    	// 	$active_asks = ProductAsk::selectRaw('COUNT(product_asks.id) as total')
    	// 								->where('ask_status','active')
    	// 								->where('seller_id',$user->id)
    	// 								->first();
  			// $expire_asks = ProductAsk::selectRaw('COUNT(product_asks.id) as total')
    	// 								->where('ask_status','inactive')
    	// 								->where('seller_id',$user->id)
    	// 								->first();
            return view('admin.users.profile.index',compact('user'));
    		// return view('admin.users.profile.index',compact('user','active_bids','expire_bids','active_asks','expire_asks'));
    	}else{
    		return redirect()->back();
    	}
    }
    public function getUserBids($id){
    	$productBids = ProductBid::where('user_id',$id)
    								->with('couponBid.coupon')
    								->orderBy('product_bids.created_at','desc')->get(); 
    	return DataTables::of($productBids)
			->addColumn('ask',function(){
				return '';
			})
			->addColumn('ask_status',function(){
				return '';
			})
			->editColumn('bid_status',function($product_bid){
				// return $product_bid->bid_status;
				if($product_bid){
					if($product_bid->bid_status == 'active'){
						return '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">'.$product_bid->bid_status.'</div>';
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
					}else{
						return '-';
					}
				}
			})
			->addColumn('action',function($data){
				$url = route('admin.user.bid.delete',$data->id);
				$type = 'bid';
				return view('admin.users.profile.action-button-ask-bid',compact('data','url','type'))->render();
			})
			->rawColumns(['bid_status', 'action','coupon'])
			->make(true);
    }
    public function getUserAsks($id){
    	$productAsks = ProductAsk::where('seller_id',$id)
    								->orderBy('product_asks.created_at','desc')->get(); 
    	return DataTables::of($productAsks)
			->addColumn('bid',function(){
				return '';
			})
			->addColumn('bid_status',function(){
				return '';
			})
			->editColumn('ask_status',function($product_ask){
				// return $product_ask->bid_status;
				if($product_ask){
					if($product_ask->ask_status == 'active'){
						return '<div class="badge bg-soft-success text-success mb-3 shadow-none m-r-5">'.$product_ask->ask_status.'</div>';
					}else{
						return '<div class="badge bg-soft-danger text-danger mb-3 shadow-none m-r-5">'.$product_ask->ask_status.'</div>';

					}
				}
			})
			->addColumn('coupon',function($product_ask){
				return '';
			})
			->addColumn('action',function($data){
				$type = 'ask';
				$url = route('admin.user.ask.delete',$data->id);
				return view('admin.users.profile.action-button-ask-bid',compact('data','url','type'))->render();
			})
			->rawColumns(['ask_status', 'action'])
			->make(true);
    }
    public function getUserBuying($id){
        $product_sales = ProductSale::where('buyer_id',$id)->with('product.productImage','productSize.productTypeSize','paymentMethodDetail')->orderBy('product_sales.created_at','desc')->get();
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
            })
            ->editColumn('sale_price',function($product_sale){
                return '£ '.$product_sale->sale_price;
            })
            ->editColumn('total_amount',function($product_sale){
                return '£ '.$product_sale->total_amount;
            }) 
            ->editColumn('transaction_fee',function($product_sale){
                return '£ '.$product_sale->transaction_fee;
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
                    return '<span class="badge bg-info text-white">Processed</span>';
                }elseif($product_sale->payment_status == 'delivered'){
                    return '<span class="badge bg-success text-white">DELIVERED</span>';
                }
            })
            ->editColumn('total_amount',function($product_sale){
                return '<b>£ '.$product_sale->total_amount.'<b>';
            })
            ->editColumn('coupon_code',function($product_sale){
                return '<div class="d-flex flex-row justify-content-start">
                            <div class="p-1">
                                <div class="d-flex flex-column justify-content-between">
                                    <div>
                                        <p class="mb-0 font-weight-bold">'.$product_sale->coupon_amount.'</p>
                                    </div> 
                                        
                                </div>
                            </div>
                        </div>';
            })
            ->editColumn('prefered_payment_method',function($product_sale){
                return '';
            })
            ->editColumn('user_payment_method_detail_id',function($product_sale){
                 if($product_sale->paymentMethodDetail){
                    if($product_sale->paymentMethodDetail->type == 'paypal'){
                        return '<span class="badge badge-info">PAYPAL</span>';
                    }elseif($product_sale->paymentMethodDetail->type == 'credit_card'){
                        return '<span class="badge badge-info">CREDIT CARD</span>';
                    }
                }else{
                    return '-';
                }
            })
            ->rawColumns(['product.product_name', 'coupon_code','payment_status','product_status','total_amount','user_payment_method_detail_id','prefered_payment_method'])
            ->make(true);
    }
    public function getUserSelling($id){
        $product_sales = ProductSale::where('seller_id',$id)->with('product.productImage','productSize.productTypeSize','paymentMethodDetail')->orderBy('product_sales.created_at','desc')->get();
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
            })
            ->editColumn('sale_price',function($product_sale){
                return '£ '.$product_sale->sale_price;
            })
            ->editColumn('total_amount',function($product_sale){
                return '£ '.$product_sale->total_amount;
            }) 
            ->editColumn('transaction_fee',function($product_sale){
                return '£ '.$product_sale->transaction_fee;
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
                    return '<span class="badge bg-info text-white">HOLD(admin)</span>';
                }elseif($product_sale->payment_status == 'delivered'){
                    return '<span class="badge bg-success text-white">DELIVERED</span>';
                }
            })
            ->editColumn('total_amount',function($product_sale){
                return '<b>£ '.$product_sale->total_amount.'<b>';
            })
            ->editColumn('coupon_code',function($product_sale){
                return '';
            })
            ->editColumn('prefered_payment_method',function($product_sale){
                if($product_sale->prefered_payment_method == 'paypal'){
                    return '<b>PAYPAL</b>';
                }elseif ($product_sale->prefered_payment_method == 'credit_card') {
                    return '<b>CREDIT CARD<b>';
                }
            })
            ->editColumn('user_payment_method_detail_id',function($product_sale){
                if($product_sale->paymentMethodDetail){
                    if($product_sale->paymentMethodDetail->type == 'paypal'){
                        return '<span class="badge badge-info">PAYPAL</span>';
                    }elseif($product_sale->paymentMethodDetail->type == 'credit_card'){
                        return '<span class="badge badge-info">CREDIT CARD</span>';
                    }
                }else{
                    return '-';
                }
            })
            ->rawColumns(['product.product_name', 'coupon_code','payment_status','product_status','total_amount','user_payment_method_detail_id','prefered_payment_method'])
            ->make(true);
    }
    public function deleteAsk($id){
    	$product_ask = ProductAsk::find($id);
    	$id = $product_ask->seller_id;
    	if($product_ask){
    		$is_deleted = $product_ask->delete();
    		$active_asks = ProductAsk::selectRaw('COUNT(product_asks.id) as total')
    									->where('ask_status','active')
    									->where('seller_id',$id)
    									->first();
    		if($is_deleted){
    			return response()->json([
    				'status' => 1,
    				'ask' => $active_asks->total
    			]);
    		}else{
    			return response()->json([
    				'status' => 0,
    			]);
    		}
    	}else{
			return response()->json([
				'status' => 0
			]);
    	}
    }
    public function deleteBid($id){
    	$product_bid = ProductBid::find($id);
    	$id = $product_bid->user_id;
    	if($product_bid){
    		if($product_bid->couponBid){
    			$product_bid->couponBid->delete();
    		}
    		$is_deleted = $product_bid->delete();
    		$active_bids = ProductBid::selectRaw('COUNT(product_bids.id) as total')
    									->where('bid_status','active')
    									->where('user_id',$id)
    									->first();
    		if($is_deleted){
    			return response()->json([
    				'status' => 1,
    				'bid'    => $active_bids->total
    			]);
    		}else{
    			return response()->json([
    				'status' => 0,
    			]);
    		}
    	}else{
			return response()->json([
				'status' => 0
			]);
    	}
    }

    public function update(Request $request){
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required', 
            'country' => 'required', 
            'user_name' => 'required',
        ]);
        $id = request()->id;
        $user = User::find($id);
        if($user){
            $is_updated = $user->update($request->except('token'));
            if($is_updated){
                $ar = [
                        'status' => 1
                    ];
            }else{
                $ar = [
                        'status' => 0
                    ];
            }
        }else{
            $ar = [
                    'status' => 0
                ];
        }
        return response()->json($ar);
    }
}
