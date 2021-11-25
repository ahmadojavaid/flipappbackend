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
use App\Http\Models\Product;
use DB;


class HomepageControllersss extends Controller
{
    public function index()
    {
    	$brands = Brand::orderBy('created_at', 'DESC')->limit(3)->get();
    	// $popularProducts = Product::with('productImage')
     //        ->join('product_sales', 'product_sales.product_id', '=', 'products.id')
     //        ->select(['product_sales.product_id','product_sales.rating',DB::raw('avg(product_sales.rating) as ra'),'products.*'])
     //        ->groupBy('product_sales.product_id')
     //        ->orderBy('ra','desc')->take(4)->get();
    	
    		
    		$lastestProducts = Product::with('productImage','singleLowestAsk')->orderby('created_at','desc')->take(4)->get();
    	


    	$highestBidProducts = Product::whereHas('allHighestBids',function($qry){
    		return $qry->select([DB::raw('avg(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	})->with('productImage')->groupBy('products.id')->take(4)->get();


        $lowestAskProducts = Product::whereHas('allLowestAsks',function($qry){
        	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('avg(product_asks.ask) as ra')])
        				->groupBy('product_asks.product_id')
        				->orderBy('product_asks.ask','asc');
        })->with('productImage','singleLowestAsk')->take(4)->get();
        
        $calenderProducts = Product::with(['productImage'])
            ->where('product_status','=',0)
            ->latest('products.created_at')
            ->take(4)
            ->get();


    	$html = view('web.homepage.content',[
    										  'brands' 				=> $brands,
    										  'lastestProducts' 	=> $lastestProducts,
    										  'highestBidProducts' 	=> $highestBidProducts,
    										  'lowestAskProducts' 	=> $lowestAskProducts,
    										  'calenderProducts'	=> $calenderProducts, 
    										  'active'				=> 1
    										])->render();
        return view('web.homepage.index',compact('html'));
    }

    public function getLatest(){
    	$brands = Brand::orderBy('created_at', 'DESC')->limit(3)->get();
    	// $popularProducts = Product::with('productImage')
     //        ->join('product_sales', 'product_sales.product_id', '=', 'products.id')
     //        ->select(['product_sales.product_id','product_sales.rating',DB::raw('avg(product_sales.rating) as ra'),'products.*'])
     //        ->groupBy('product_sales.product_id')
     //        ->orderBy('ra','desc')->take(4)->get();
    	
    		
    		$lastestProducts = Product::with('productImage','singleLowestAsk')->orderby('created_at','desc')->take(4)->get();
    	


    	$highestBidProducts = Product::whereHas('allHighestBids',function($qry){
    		return $qry->select([DB::raw('avg(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	})->with('productImage')->groupBy('products.id')->take(4)->get();


        $lowestAskProducts = Product::whereHas('allLowestAsks',function($qry){
        	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('avg(product_asks.ask) as ra')])
        				->groupBy('product_asks.product_id')
        				->orderBy('product_asks.ask','asc');
        })->with('productImage','singleLowestAsk')->take(4)->get();
        
        $calenderProducts = Product::with(['productImage'])
            ->where('product_status','=',0)
            ->latest('products.created_at')
            ->take(4)
            ->get();


    	$html = view('web.homepage.content',[
    										  'brands' 				=> $brands,
    										  'lastestProducts' 	=> $lastestProducts,
    										  'highestBidProducts' 	=> $highestBidProducts,
    										  'lowestAskProducts' 	=> $lowestAskProducts,
    										  'calenderProducts'	=> $calenderProducts, 
    										  'active'				=> 1
    										])->render();
        return response()->json($html);
    }

    public function getSupreme(){
    	// $brands = Brand::orderBy('created_at', 'DESC')->limit(3)->get();
    	$lastestProducts = Product::where('is_supreme',1)->with('productImage','singleLowestAsk')->orderby('created_at','desc')->take(4)->get();
    	$highestBidProducts = Product::where('is_supreme',1)->whereHas('allHighestBids',function($qry){
    		return $qry->select([DB::raw('avg(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	})->with('productImage')->groupBy('products.id')->take(4)->get();


        $lowestAskProducts = Product::where('is_supreme',1)->whereHas('allLowestAsks',function($qry){
        	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('avg(product_asks.ask) as ra')])
        				->groupBy('product_asks.product_id')
        				->orderBy('product_asks.ask','asc');
        })->with('productImage','singleLowestAsk')->take(4)->get();
        
        $calenderProducts = Product::where('is_supreme',1)->with(['productImage'])
            ->where('product_status','=',0)
            ->latest('products.created_at')
            ->take(4)
            ->get();


    	$html = view('web.homepage.content',[
    										  'brands' 				=> [],
    										  'lastestProducts' 	=> $lastestProducts,
    										  'highestBidProducts' 	=> $highestBidProducts,
    										  'lowestAskProducts' 	=> $lowestAskProducts,
    										  'calenderProducts'	=> $calenderProducts, 
    										  'active'				=> 2
    										])->render();

        return response()->json($html);
    }

    public function getPopular(){
    	$brands = Brand::orderBy('created_at', 'DESC')->limit(3)->get();
    	$popularProducts = Product::with('productImage')
            ->join('product_sales', 'product_sales.product_id', '=', 'products.id')
            ->select(['product_sales.product_id','product_sales.id as p_s_id','product_sales.rating',DB::raw('avg(product_sales.rating) as ra'),'products.*'])
            ->groupBy('product_sales.product_id')
            ->orderBy('ra','desc')->take(4)->get();
            dd($popularProducts);  	


    	$highestBidProducts = Product::whereHas('allHighestBids',function($qry){
    		return $qry->select([DB::raw('avg(product_bids.bid) as ra')])->orderBy('ra','desc')->groupBy('product_bids.product_id');
    	})->with('productImage')->groupBy('products.id')->take(4)->get();


        $lowestAskProducts = Product::whereHas('allLowestAsks',function($qry){
        	return $qry->select([ 'product_asks.ask','product_asks.product_id',DB::raw('avg(product_asks.ask) as ra')])
        				->groupBy('product_asks.product_id')
        				->orderBy('product_asks.ask','asc');
        })->with('productImage','singleLowestAsk')->take(4)->get();
        
        $calenderProducts = Product::with(['productImage'])
            ->where('product_status','=',0)
            ->latest('products.created_at')
            ->take(4)
            ->get();


    	$html = view('web.homepage.content',[
    										  'brands' 				=> $brands,
    										  'lastestProducts' 	=> $popularProducts,
    										  'highestBidProducts' 	=> $highestBidProducts,
    										  'lowestAskProducts' 	=> $lowestAskProducts,
    										  'calenderProducts'	=> $calenderProducts, 
    										  'active'				=> 3
    										])->render();
        return response()->json($html);
    }


}