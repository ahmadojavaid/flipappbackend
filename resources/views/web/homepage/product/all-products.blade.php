@extends('layouts.homepage.master')
@section('title', 'Products')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">
        <section style="background-color: #F6F6F6;" class="mt-5 mb-5 pt-2 pb-2 pr-5 pl-5">
        	<div class="row">
        		@if($all == 1)
        			<h2>Just Drop Products</h2>
        		@elseif($all == 2)
        			<h2>All Lowest Ask Products</h2>
        		@elseif($all == 3)
        			<h2>All Highest Bid Products</h2>
        		@elseif($all == 4)
        			<h2>All Supreme Lowest Ask Products</h2>
        		@elseif($all == 5)
        			<h2>All Supreme Highest Bid Products</h2>
        		@elseif($all == 7)
        			<h2>All Latest Products</h2>
        		@endif
        	</div>
            <div class="row pt-5 pb-5 accordion" id="accordionExample">
            	{{--  {{dd($products)}} --}}
            	@foreach($products as $product)
	                <div class="col-sm-12 col-md-4 p-2 float_left">
	                	@if($all > 1)
	                	<a href="{{route('single_product',$product->id)}}">
	                		@endif
		                    <div class="card text-white border-0 shadow rounded-0 blog-card-height">
		                        <img src="{{ asset(@$product->productImage->image_url) }}" class="card-img img-fluid product_all_page_img" alt="...">
		                        <div class="card-img-overlay p-0">
		                            <div class=" p-2 border-0 blog-card-header">
		                            </div>
		                        </div>
		                        
			                        <div class="card  border-0 m-2">
			                            <!-- <div class="card-header color-black  " id="">
			                              {{$product->product_name}}
			                            </div> -->
			                            <div class="card-body color-black">
			                            	<p> {{$product->product_name}} </p><br>
			                            	@if(($all != 3) && ($all != 5))
				                            	@if($product->singleLowestAsk)
				                            		@if($product->singleLowestAsk->ask > 0)
				                            			<h6>LOWEST ASK &nbsp &nbsp  <b>£ {{$product->singleLowestAsk->ask}}</b></h6>
				                            		@else
				                            			<h6>LOWEST ASK &nbsp &nbsp  <b>£ - </b></h6>
				                            		@endif
				                            	@else
			                            			<h6>LOWEST ASK &nbsp &nbsp  <b>£ - </b></h6>
			                            		@endif
			                            	@else
			                            		 @if($product->singleHighestBid)
				                            		@if($product->singleHighestBid->bid > 0)
				                            			<h6>Highest BID &nbsp &nbsp  <b>£ {{$product->singleHighestBid->bid}}</b></h6>
				                            		@else
				                            			<h6>Highest BID &nbsp &nbsp  <b>£ - </b></h6>
				                            		@endif
				                            	@else
			                            			<h6>Highest BID &nbsp &nbsp  <b>£ - </b></h6>
			                            		@endif
			                            	@endif
			                            </div>
		                        	</div>
		                    </div>
		                @if($all > 1)
	                	</a>
	                	@endif
	                </div>
                @endforeach
                  	
            	
            </div>
            <div class="row">
	  	<div class="col-md-12">
	  		<div class="pull-right"> 
	  			{{$products->render()}}
	  		</div>
	  	</div>
	  </div>
        </section>
    </div>
   
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
	<script type="text/javascript">
		$(document).ready(function(){
			 
		});
	</script>
@endsection