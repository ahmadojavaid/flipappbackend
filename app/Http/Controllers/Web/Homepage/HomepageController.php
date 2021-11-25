<?php
/**
 * Created by PhpStorm.
 * User: JBBravo
 * Date: 18-Oct-19
 * Time: 5:18 PM
 */

namespace App\Http\Controllers\Web\Homepage;


use App\Http\Controllers\Controller;
use App\Http\Models\Brand;
use Illuminate\Http\Request;
use App\User;
use App\Http\Models\Product;
use App\Http\Models\ProductAsk;
use DB;
use Auth;
use App\Http\Models\VerificationCode as VerificationModel;


class HomepageController extends Controller
{
    public function index()
    {
    	$justDroppedProducts = Product::select('products.*','product_asks.*','products.id')
                                        ->where('product_status', 1)
                                        ->leftJoin('product_asks','product_asks.product_id','!=','products.id')
                                        ->with('productImage')
                                        ->groupBy('products.id')
                                        ->orderby('products.created_at','desc')
                                        ->take(4)
                                        ->get();
        $lastestProducts = Product::select('products.*','products.id')
                                    ->where('product_status', 1)
                                    ->whereHas('lowestAsk',function($qry){
                                        $qry->groupBy(['product_id','product_size_id'])->where('ask_status','active');
                                    })
                                    // ->with('productImage','lowestAsk')
                                    ->with('productImage','singleLowestAsk')
                                    ->orderby('products.created_at','desc')
                                    ->take(4)
                                    ->get();
    	// $highestBidProducts = Product::where('product_status', 1)
     //                                    ->whereHas('allHighestBids',function($qry){
    	// 	                                  return $qry->select([DB::raw('max(product_bids.bid) as ra')])
     //                                                 ->orderBy('ra','desc')
     //                                                 ->where('bid_status','active')
     //                                                 ->groupBy('product_bids.product_id');
    	//                                 })
     //                                    ->with('productImage','singleHighestBid')
     //                                    ->groupBy('products.id')
     //                                    ->take(4)
     //                                    ->get();
     //    dd($highestBidProducts);
        $highestBidProducts = Product::selectRaw('products.*,MAX(product_bids.bid) AS high_bid,product_bids.created_at')
                                        ->where('product_status', 1)
                                        ->join('product_bids','product_bids.product_id','products.id')
                                        ->where('product_bids.bid_status','active')
                                        ->orderBy('product_bids.created_at','desc')
                                        ->groupBy('product_bids.product_id')
                                        ->with('productImage','singleHighestBid')
                                        ->take(4)
                                        ->get();
        // dd($highestBidProducts->singleHighestBid);

        $lowestAskProducts = Product::selectRaw('products.*,MIN(product_asks.ask) AS min_ask,product_asks.created_at')
                                        ->where('product_status', 1)
                                        ->join('product_asks','product_asks.product_id','products.id')
                                        ->where('product_asks.ask_status','active')
                                        ->orderBy('product_asks.created_at','desc')
                                        ->groupBy('product_asks.product_id')
                                        ->with('productImage','singleLowestAsk')
                                        ->take(4)
                                        ->get();
                                        // SELECT `products`.*,MIN(`product_asks`.`ask`) AS `min_asks`,`product_asks`.`created_at`
                                        // FROM `products`
                                        // INNER JOIN `product_asks` ON `product_asks`.`product_id` = `products`.`id`
                                        // WHERE `product_status` = 1
                                        // GROUP BY `product_asks`.`product_id`
                                        // ORDER BY `product_asks`.`created_at` DESC
                                        // LIMIT 4

                                        // $lowestAskProducts = Product::where('product_status', 1)
                                        // ->whereHas('allLowestAsks',function($qry){
                                        //    return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
                                        //     ->groupBy('product_asks.product_id')
                                        //     ->where('ask_status','active');
                                        // })
                                        // ->orderBy('created_at','desc')
                                        // ->with('productImage','singleLowestAsk')
                                        // ->take(4)
                                        // ->get();
        // dd($lowestAskProducts);

        $calenderProducts = Product::where('product_status', 2)
                                    ->with(['productImage'])
                                    ->latest('products.created_at')
                                    ->take(4)
                                    ->get();


    	$html = view('web.homepage.content',[
    										  'justDroppedProducts' => $justDroppedProducts,
    										  'lastestProducts' 	=> $lastestProducts,
    										  'highestBidProducts' 	=> $highestBidProducts,
    										  'lowestAskProducts' 	=> $lowestAskProducts,
    										  'calenderProducts'	=> $calenderProducts,
    										  'active'				=> 1,
                                              'paginate_page'       => 0
    										])->render();
        return view('web.homepage.index',compact('html'));
    }

   /***
    public function getLatest(){
    	$justDroppedProducts = Product::select('products.*','product_asks.*','products.id')
                                        ->where('product_status', 1)
                                        ->leftJoin('product_asks','product_asks.product_id','!=','products.id')
                                        ->with('productImage')
                                        ->groupBy('products.id')
                                        ->orderby('products.created_at','desc')
                                        ->take(4)
                                        ->get();
        $lastestProducts = Product::select('products.*','products.id')
                                    ->where('product_status', 1)
                                    ->whereHas('lowestAsk',function($qry){
                                        $qry->groupBy(['product_id','product_size_id'])->where('ask_status','active');
                                    })
                                    ->with('productImage','singleLowestAsk')
                                    ->orderby('products.created_at','desc')
                                    ->take(4)
                                    ->get();
        $highestBidProducts = Product::where('product_status', 1)
                                        ->whereHas('allHighestBids',function($qry){
                                              return $qry->select([DB::raw('max(product_bids.bid) as ra')])
                                                     ->orderBy('ra','desc')
                                                     ->groupBy('product_bids.product_id');
                                        })
                                        ->with('productImage','singleHighestBid')
                                        ->groupBy('products.id')
                                        ->take(4)
                                        ->get();


        $lowestAskProducts = Product::where('product_status', 1)
                                        ->whereHas('allLowestAsks',function($qry){
                                           return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
                                            ->groupBy('product_asks.product_id')
                                            ->orderBy('product_asks.ask','desc')
                                            ->where('ask_status','active');
                                        })
                                        ->with('productImage','singleLowestAsk')
                                        ->take(4)
                                        ->get();

        $calenderProducts = Product::where('product_status', 2)
                                    ->with(['productImage'])
                                    ->latest('products.created_at')
                                    ->take(4)
                                    ->get();


        $html = view('web.homepage.content',[
                                              'justDroppedProducts' => $justDroppedProducts,
                                              'lastestProducts'     => $lastestProducts,
                                              'highestBidProducts'  => $highestBidProducts,
                                              'lowestAskProducts'   => $lowestAskProducts,
                                              'calenderProducts'    => $calenderProducts,
                                              'active'              => 1,
                                              'paginate_page'       => 0
                                            ])->render();
        return response()->json($html);
    }
    ***/
    public function getLatest(){
        $justDroppedProducts = Product::select('products.*','product_asks.*','products.id')
                                        ->where('product_status', 1)
                                        ->leftJoin('product_asks','product_asks.product_id','!=','products.id')
                                        ->with('productImage')
                                        ->groupBy('products.id')
                                        ->orderby('products.created_at','desc')
                                        ->take(4)
                                        ->get();
        $lastestProducts = Product::select('products.*','products.id')
                                    ->where('product_status', 1)
                                    ->whereHas('lowestAsk',function($qry){
                                        $qry->groupBy(['product_id','product_size_id'])->where('ask_status','active');
                                    })
                                    ->with('productImage','singleLowestAsk')
                                    ->orderby('products.created_at','desc')
                                    ->take(4)
                                    ->get();
        $highestBidProducts = Product::selectRaw('products.*,MAX(product_bids.bid) AS high_bid,product_bids.created_at')
                                        ->where('product_status', 1)
                                        ->join('product_bids','product_bids.product_id','products.id')
                                        ->where('product_bids.bid_status','active')
                                        ->orderBy('product_bids.created_at','desc')
                                        ->groupBy('product_bids.product_id')
                                        ->with('productImage','singleHighestBid')
                                        ->take(4)
                                        ->get();
        // dd($highestBidProducts->singleHighestBid);

        $lowestAskProducts = Product::selectRaw('products.*,MIN(product_asks.ask) AS min_ask,product_asks.created_at')
                                        ->where('product_status', 1)
                                        ->join('product_asks','product_asks.product_id','products.id')
                                        ->where('product_asks.ask_status','active')
                                        ->orderBy('product_asks.created_at','desc')
                                        ->groupBy('product_asks.product_id')
                                        ->with('productImage','singleLowestAsk')
                                        ->take(4)
                                        ->get();
        $calenderProducts = Product::where('product_status', 2)
                                    ->with(['productImage'])
                                    ->latest('products.created_at')
                                    ->take(4)
                                    ->get();
        $html = view('web.homepage.content',[
                                              'justDroppedProducts' => $justDroppedProducts,
                                              'lastestProducts'     => $lastestProducts,
                                              'highestBidProducts'  => $highestBidProducts,
                                              'lowestAskProducts'   => $lowestAskProducts,
                                              'calenderProducts'    => $calenderProducts,
                                              'active'              => 1,
                                              'paginate_page'       => 0
                                            ])->render();
        return response()->json($html);
    }

    public function getSupreme(){
        $name = 'supreme';
    	// $brands = Brand::orderBy('created_at', 'DESC')->limit(3)->get();
    	$lastestProducts = Product::where('product_status', 1)
                                    ->whereHas('brandName',function($qry){
                                        $qry->where('brand_name','supreme');
                                    })
                                    ->whereHas('lowestAsk',function($qry){
                                        $qry->groupBy(['product_id','product_size_id'])
                                        ->where('ask_status','active');
                                    })
                                    ->with('productImage','singleLowestAsk')
                                    ->orderby('created_at','desc')
                                    ->paginate(config('constants.paginate_per_page'));

    	// $highestBidProducts = Product::where('product_status', 1)->whereHas('brandName',function($qry) use ($name){
     //        return $qry->where('brand_name',$name);
     //    })->whereHas('allHighestBids',function($qry){
    	// 	return $qry->select([DB::raw('max(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	// })->with('productImage')->groupBy('products.id')->take(4)->get();


     //    $lowestAskProducts = Product::where('product_status', 1)->whereHas('brandName',function($qry) use ($name){
     //        return $qry->where('brand_name',$name);
     //    })->whereHas('allLowestAsks',function($qry){
     //    	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
     //    				->groupBy('product_asks.product_id')
     //    				->orderBy('product_asks.ask','asc');
     //    })->with('productImage','singleLowestAsk')->take(4)->get();

     //    $calenderProducts = Product::where('product_status', 2)->whereHas('brandName',function($qry) use ($name){
     //        return $qry->where('brand_name',$name);
     //    })->with(['productImage'])
     //        ->latest('products.created_at')
     //        ->take(4)
     //        ->get();


    	$html = view('web.homepage.content',[
    										  'justDroppedProducts'	=> [],
    										  'lastestProducts' 	=> $lastestProducts,
    										  'highestBidProducts' 	=> [],
    										  'lowestAskProducts' 	=> [],
    										  'calenderProducts'	=> [],
    										  'active'				=> 2,
                                              'paginate_page'       => 1
    										])->render();

        return response()->json($html);
    }

    public function getPopular(){
        // $lastestProducts = Product::where('product_status', 1)
        //                             ->whereHas('brandName',function($qry){
        //                                 $qry->where('brand_name','supreme');
        //                             })
        //                             ->whereHas('lowestAsk',function($qry){
        //                                 $qry->groupBy(['product_id','product_size_id'])
        //                                 ->where('ask_status','active');
        //                             })->whereHas('getPopularProduct',function($qry){

        //                             })
        //                             ->with('productImage','singleLowestAsk')
        //                             ->orderby('created_at','desc')
        //                             ->paginate(config('constants.paginate_per_page'));
    	// $brands = Brand::orderBy('created_at', 'DESC')->limit(3)->get();
    	// $popularProducts = Product::where('product_status', 1)->with('productImage')
     //        ->join('product_sales', 'product_sales.product_id', '=', 'products.id')
     //        ->select(['product_sales.product_id','product_sales.id as p_s_id','product_sales.rating',DB::raw('max(product_sales.rating) as ra'),'products.*'])
     //        ->groupBy('product_sales.product_id')
     //        ->take(4)->get();



    	// $highestBidProducts = Product::where('product_status', 1)->whereHas('allHighestBids',function($qry){
    	// 	return $qry->select([DB::raw('max(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	// })->with('productImage')->groupBy('products.id')->take(4)->get();


     //    $lowestAskProducts = Product::where('product_status', 1)->whereHas('allLowestAsks',function($qry){
     //    	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('min(product_asks.ask) as ra')])
     //    				->groupBy('product_asks.product_id')
     //    				->orderBy('product_asks.ask','asc');
     //    })->with('productImage','singleLowestAsk')->take(4)->get();

     //    $calenderProducts = Product::where('product_status', 2)->with(['productImage'])
     //        ->latest('products.created_at')
     //        ->take(4)
     //        ->get();


    	// $html = view('web.homepage.content',[
    	// 									  'brands' 				=> $brands,
    	// 									  'lastestProducts' 	=> $popularProducts,
    	// 									  'highestBidProducts' 	=> $highestBidProducts,
    	// 									  'lowestAskProducts' 	=> $lowestAskProducts,
    	// 									  'calenderProducts'	=> $calenderProducts,
    	// 									  'active'				=> 3
    	// 									])->render();
        $html = '<center><b>Coming Soon</b></center>';
        return response()->json($html);
    }


    public function faq()
    {
        return view('web.homepage.faq');
    }

    public function howItWorks()
    {
        return view('web.homepage.how-it-works');
    }

    public function userReviews()
    {
        return view('web.homepage.reviews');
    }

    public function termsAndConditions()
    {
        return view('web.homepage.terms-and-conditions');
    }

    public function getOurApp()
    {
        return view('web.homepage.get-our-app');
    }

    public function contactUs()
    {
        return view('web.homepage.contact-us');
    }

    public function news()
    {
        return view('web.homepage.news');
    }

    public function loginSignUp()
    {
        return view('web.homepage.login');
    }
    public function verificationCode()
    {
        return view('web.homepage.verification-code');
    }
    public function verificationCodeSubmit(Request $request){
        $this->validate($request, [
            'code' => 'required',
        ]);
        $code = request()->code;
        $verificationCodeObj = VerificationModel::where('code',$code)->first();
        if($verificationCodeObj){
            if($verificationCodeObj->status == 'active'){
                $user_id = $verificationCodeObj->user_id;
                $verificationCodeObj->status = 'inactive';
                $is_saved = $verificationCodeObj->save();
                if($is_saved){
                    $user = User::where('id',$user_id)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
                    VerificationModel::where('user_id',$user_id)->update(['status'=>'inactive']);
                    $is_login = Auth::loginUsingId($user_id);
                    if($is_login){
                        return redirect()->route('seller.dashboard');
                    }
                }
            }else{
                flash('Sorry! Your token has been expired...')->error();
                return redirect()->back();
            }

        }else{
            flash('Sorry! Token Not Exist.')->error();
            return redirect()->back();
        }
    }
    public function allBrands(){
        $brands = Brand::paginate(config('constants.paginate_per_page'));
        return view('web.homepage.all-brands',compact('brands'));
    }

}
