<?php

namespace App\Http\Controllers\Web\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Http\Models\Product; 
use App\Http\Models\ProductSize;
use App\Http\Models\ProductAsk;
use App\Http\Models\ProductBid;
use App\Http\Models\Setting;
use App\Http\Models\ProductTypeSize;
use Auth;
use Carbon\Carbon;


class PortfolioController extends Controller
{
    // public function index(){
    // 	return view('web.dashboard.portfolio.index');
    // }
    public function asks(){
        return view('web.dashboard.portfolio.asks.index');
    }
    public function bids(){
        return view('web.dashboard.portfolio.bids.index');
    }
    public function getUserBids(){
    	$productBids = ProductBid::where('user_id',Auth::user()->id)->where('bid_status','!=','buy')->with('product','couponBid.coupon')->orderBy('product_bids.created_at','desc')->get(); 
        
    	return DataTables::of($productBids)
			->addColumn('ask',function(){
				return '';
			})
            ->editColumn('product.product_name',function($product_ask){
                return @$product_ask->product->product_name.'<br>'.'Size : '.@$product_ask->productSize->productTypeSize->name.'<br> Condition : '.@$product_ask->condition;
            })
			->addColumn('ask_status',function(){
				return '';
			})
			->editColumn('highest_bid',function($product_bid){
				return $product_bid->getHighestBid($product_bid->product_id,$product_bid->product_size_id);
			})
			->editColumn('lowest_ask',function($product_bid){
				return $product_bid->getLowestAsk($product_bid->product_id,$product_bid->product_size_id);
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
					}
				}
			})
			->rawColumns(['bid_status', 'action','coupon','product.product_name'])
			->editColumn('action',function($product_bid){
				 return '<td>
				 			<a href="'.route('seller.bid.edit',$product_bid->id).'">
				 				<img src="'.asset('assets/img/icons/pencil-edit-button (1).png').'" />
				 				</a>
				 		</td>';
			})->make(true);
    }
    public function getUserAsks(){
    	$productAsks = ProductAsk::where('seller_id',Auth::user()->id)->where('ask_status','!=','buy')->with('product')->orderBy('product_asks.created_at','desc');

    	return DataTables::of($productAsks)
			->addColumn('bid',function(){
				return '';
			})
			->editColumn('highest_bid',function($product_ask){
				return '';
			})
            ->editColumn('product.product_name',function($product_ask){
                return $product_ask->product->product_name.'<br>'.'Size : '.$product_ask->productSize->productTypeSize->name.'<br> Condition : '.$product_ask->condition;
            })
			->editColumn('lowest_ask',function($product_ask){
                if($product_ask->product){
                    if($product_ask->product->singleLowestAsk){
                        return $product_ask->product->singleLowestAsk->ask;
                    }
                }
				// return $product_ask->getLowestAsk($product_ask->product_id,$product_ask->product_size_id,Auth::user()->id);
			})
			->addColumn('bid_status',function($product_ask){
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
			->rawColumns(['bid_status', 'ask_status','action','coupon','product.product_name'])
			->editColumn('action',function($product_ask){
				 return '<td>
				 			<a href="'.route('seller.ask.edit',$product_ask->id).'">
				 				<img src="'.asset('assets/img/icons/pencil-edit-button (1).png').'" />
				 			</a>
				 		</td>';
			})->make(true);
    }
    public function search(){
    	return view('web.dashboard.portfolio.add.search-product-portfolio');
    }
    public function getProducts(){
    	$search = request()->search;
    	if(!empty($search)){
    		$products = Product::where('product_name','like','%'.$search.'%')
    						->where('product_status',1)
                            ->limit(15)
    						->with('productImage','ProductSizes.productTypeSize')
    						->get();
	    	if(count($products) > 0){
	    		$res = [
    				'status' => 1,
    				'products' => $products,
    			];
	    	}else{
	    		$res = [
    				'status' => 0,
    			];
	    	}
	    	return response()->json($res,200);
    	}else{
    		$res = [
    			'status' => 0,
    		];
    		return response()->json($res,422);
    	}
    }
    public function addproduct(){
    	$id = request()->id;
    	$product = Product::where('id',$id)->where('product_status',1)->first();
    	if($product){
    		return view('web.dashboard.portfolio.add.add-product',compact('product'));
    	}else{
    		return redirect()->back();
    	}
    }

    public function savePortfolio(Request $request){
    	// dd($request->all());
    	  $this->validate($request, [
            'condition' => 'required',
            'size' => 'required',
            'price' => 'required', 
            'day' => 'required', 
            'month' => 'required', 
        ]);

    	$date = request()->year.'-'.request()->month.'-'.request()->day;
    	if(!empty(request()->product_id) && !empty(request()->size)){
            	$productAsk = ProductAsk::where('product_id',request()->product_id)
                                      ->where('product_size_id',request()->size)
                                      ->where('seller_id',Auth::user()->id)
                                      ->where('condition',request()->condition)
                                      ->where('ask_status','portfolio')
                                      ->first();
                $productAskActive = ProductAsk::where('product_id',request()->product_id)
                                      ->where('product_size_id',request()->size)
                                      ->where('seller_id',Auth::user()->id)
                                      ->where('condition',request()->condition)
                                      ->where('ask_status','active')
                                      ->first();
            if($productAsk || $productAskActive){
                flash("Error, You can't add a product in Portfolio. Product already added.")->error();
                return redirect()->back();
            }
        }else{
            flash("Error, Something went wrong")->error();
            return redirect()->back();
        }
    	// $product_ask = new ProductAsk();
    	// $product_ask->product_id = request()->product_id;
    	// $product_ask->product_size_id = request()->size;
    	// $product_ask->purchase_date = $date;
    	// $product_ask->purchase_price = request()->price;
    	// $product_ask->seller_id = Auth::user()->id;
    	// $product_ask->ask_status = 'portfolio';
    	// $product_ask->condition = request()->condition;
    	// $is_saved = $product_ask->save();
        $request->session()->put('purchase_date',$date);
        $request->session()->put('purchase_price',request()->price);
        $request->session()->put('condition',request()->condition);
        $request->session()->put('product_size_id',request()->size);
        $request->session()->put('product_size_name',request()->size_name);
        $request->session()->put('product_id',request()->product_id);
        $request->session()->save();
    	// if($is_saved){
    		return redirect()->route('seller.portfolio.preview');
    	// }else{
    	// 	return redirect()->back();
    	// }
    }
    public function preview(){
        // dd(session()->all());
    	$product = Product::where('id',session('product_id'))
                                ->where('product_status',1)
                                ->first();

    	return view('web.dashboard.portfolio.add.preview',compact('product'));
    }

    public function placeAsk(){
        // if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
            $setting = Setting::where('key','paypal_fee')->first();
        	$shipment_fee = Setting::where('key','shipment_fee')->first();
        	$product = Product::where('id',session('product_id'))->where('product_status',1)->first();
        		return view('web.dashboard.portfolio.add.place_ask',compact('product','setting','shipment_fee'));
        // }else{
        //     flash('Error!, Please Add the at least one payment method');
        //     return redirect()->route('seller.setting.index');
        // }
    }
    public function savePlaceAsk(Request $request){
    	// dd(request()->all());
    	$setting = Setting::where('key','paypal_fee')->first();
        $this->validate($request, [
            'ask' => 'required',
            'term_condition' => 'required',
            'expiry_day' => 'required',
        ]);
        if(!empty(Auth::user()->paymentPaypal)  || !empty(Auth::user()->paymentCreditCard)){
        }else{
            flash('Error!, Please Add the at least one payment method')->error();
            return redirect()->back();
        }
    	$product_id = request()->product_id;
    	$product_size_id = request()->product_size;
    	$ask = request()->ask;
        $condition = request()->condition;
    	$expiry_date = Carbon::now()->addDays(request()->expiry_day);
    	$expiry_date = $expiry_date->toDateString();
        if(!empty($product_id) && !empty($product_size_id)){
            $productAsk = ProductAsk::where('product_id',$product_id)
                                      ->where('product_size_id',$product_size_id)
                                      ->where('seller_id',Auth::user()->id)
                                      ->where('condition',request()->condition)
                                      ->where('ask_status','active')
                                      ->first();
            if($productAsk){
                flash("Error, You can't place a Ak. Your Ask already placed.")->error();
                return redirect()->back();
            }
        }else{
            flash("Error, Something went wrong")->error();
            return redirect()->back();
        }


    	if($setting->value > 0){
    		$transaction_fee = ((float)$setting->value/100)*$ask;
    		$total = (float)$ask - (float)$transaction_fee;
    	}else{
    		$total = $ask;
    	}
    	$product_ask = new ProductAsk();
		$product_ask->product_id = $product_id;
    	$product_ask->product_size_id = $product_size_id;
        $product_ask->ask = $ask;
    	$product_ask->condition = $condition;
    	$product_ask->transaction_fee = $transaction_fee;
        $product_ask->expires_at = $expiry_date;
    	$product_ask->seller_id = Auth::user()->id;
    	$product_ask->ask_status = 'active';
    	$product_ask->total = $total;
    	$is_saved = $product_ask->save();
    	if($is_saved){
            session()->forget('purchase_date');
            session()->forget('purchase_price');
            session()->forget('condition');
            session()->forget('product_size_id');
            session()->forget('product_size_name');
            session()->forget('product_id');
        	//flash('Success, Record Updated Successfully.')->success();
        	return redirect()->route('seller.ask.thankyou',$product_ask->id);
    	}else{
    		flash('Error, Something went wrong')->error();
    		return redirect()->back();
    	}
    	
    }
}
