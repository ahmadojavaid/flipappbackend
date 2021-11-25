@extends('layouts.homepage.master')
@section('title', 'Products')
@section('content')


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">
	    	<div class="row">
					<div class="col-sm-12 col-md-3">
					</div>
					<div class="col-sm-8 col-md-3 ">
						<div class="d-flex flex-column justify-content-center single-item-padding-left-right">
								<a href="{{route('seller.portfolio.add')}}?id={{$product->id}}" class="btn p-2 rounded-0 mt-4 border-0 shadow font-weight-bold" style="width: 12rem;background-color: #EFEFEF;font-size: 12px;">
	                    			<b style="font-size: 22px;">+</b> Portfolio
	            				</a>
						</div>
					</div>
					{{-- <div class="col-sm-8 col-md-3 ">
						<div class="d-flex flex-column justify-content-center single-item-padding-left-right">
								<a href="javascript:void(0)" class="btn p-2 mt-4 rounded-0 border-0 shadow font-weight-bold" style="width: 12rem;background-color: #EFEFEF;font-size: 12px;">
	                    			<b style="font-size: 22px;">+</b> Follow
	                    		</a>
						</div>
					</div> --}}
			</div>
			@include('flash::message')
			<div class="row pt-4  pb-3">

				<!-- <div class="col text-center">
					<img src="./img/products/Screenshot%202019-07-13%20at%2016.16.24.png" class="single-item-img">
				</div> -->
				<div class="col-lg-6 col-sm-12 offset-lg-3">

					{{-- <div id="carouselExampleControls" class="carousel slide  " data-ride="carousel">
						<div class="carousel-inner">
							@foreach($product->productImages as $key => $product_images)
								<div class="carousel-item {{($key == 0) ? 'active' : ''}}">
								  <img src="{{asset(@$product_images->image_url)}}" class="  img-fluid">
								</div>
							@endforeach
						</div>
						<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div> --}}




					<section class="carousel slide cid-ruv1vrquBa" data-interval="false" data-ride="false" id="slider2-0">
						<div class="container content-slider">
							<div class="content-slider-wrap">
								<div>
									<div class="mbr-slider slide carousel" data-pause="true" data-keyboard="false" data-ride="false" data-interval="false">
										<ol class="carousel-indicators">
											@foreach($product->productImages as $key => $product_images)
											<li data-app-prevent-settings="" data-target="#slider2-0" data-slide-to="{{$key}}"></li>
											@endforeach
										</ol>
										<div class="carousel-inner" role="listbox">
											@foreach($product->productImages as $key => $product_images)
												<div class="carousel-item {{($key == 0) ? 'active' : ''}} slider-fullscreen-image" data-bg-video-slide="false" style="background-image: url(assets/images/4-1200x800.jpg);">
													<div class="container container-slide ">
														<div class="image_wrapper ">

															<img src="{{asset(@$product_images->image_url)}}" class="img-fluid ">
															<div class="carousel-caption justify-content-center  ">
																<div class="col-10 align-center">

																</div>
															</div>
														</div>
													</div>
												</div>
											@endforeach
										</div>
										<a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#slider2-0">
											<span aria-hidden="true" class="mbri-left mbr-iconfont"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a data-app-prevent-settings="" class="carousel-control carousel-control-next"  role="button" data-slide="next"   href="#slider2-0">
											<span aria-hidden="true" class="mbri-right mbr-iconfont"></span><span class="sr-only">Next</span>
										</a>
									</div>
								</div>
							</div>
							{{-- <form class="form_hidden" method="post" action="{{route('seller.buy.product_size')}}">
								@csrf
								<input type="hidden" name="product_id" class="form_product_id_hi">
								<input type="hidden" name="size_id" class="form_size_id_hi">
								<input type="hidden" name="condition" class="form_condition_hi">
							</form> --}}
						</div>
					</section>


					<input type="hidden" name="product_id" value="{{request()->id}}" class="product_id_gg">
					<input type="hidden" name="size_id"  class="size_id_gg">

				</div>
				<input type="hidden" name="condition" value="{{session('condition')}}" class="condition_check">
			</div>
			<div class="row pt-3 pb-3">
				<div class="col text-center">
					<h4 style="color: #525252;">{{$product->product_name}}</h4>
				</div>
			</div>
			<div class="row">
				<div class="col text-center">
					<P class="mb-0 d-inline pr-2" style="color: #8D8D8D;vertical-align: middle;">SIZE</p>
					<button class="btn p-2 rounded-0 text-white bg-dark btn_size_body shadow-none" data-toggle="modal" data-target="#exampleModalCenter" style="width: 5rem;border: 2px white solid;padding: 3px !important;">-
					</button>
					<div class="row ">
				        <div class="spinner_center">
					        <div class="spinner-grow spinner-grow-small spinner_f hide" role="status">
					          <span class="sr-only">Loading...</span>
					        </div>
				    	</div>
			    	</div>
				</div>
			</div>

			<section class="pt-3 mb-5 mt-4 shadow" style="background-color: #F1F1F1;">
				<div class="row">
					<div class="col-sm-12 col-md-3">

					</div>
					{{-- <div class="col-sm-8 col-md-6 hide product_ask_no  alert alert-danger text-white" style="background: #b9404b;">
						Please Add the Product to Portfolio First
					</div> --}}
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-3">

					</div>
					<div class="col-sm-8 col-md-3 ">
						<div class="d-flex flex-column justify-content-center single-item-padding-left-right">
							<div class="pb-2">
								<p class="mb-0" style="color: #888888;">LOWEST ASK:</p>
							</div>
							<div>
								{{-- <button> --}}
								<div class="card single-item-red-card buy_now_btn">
									<div class="card-body">

										<div class="d-flex flex-row justify-content-start">
											<div style="border-right: 1px white solid;padding-right: 8px;">

												<p class="mb-0">BUY</p>
												<p class="mb-0">NOW</p>

											</div>
											<div>
												<p class="h2 font-weight-bold mb-0 pl-xl-5 pl-lg-3 pl-md-2 single-item-padding-left-xs min_ask">£ -</p>
												<input type="hidden" class="min_ask_in" >
											</div>
										</div>

									</div>
								</div>
							{{-- </button> --}}
							</div>
							<div class="d-flex flex-row justify-content-center pt-2">
								<button class="mb-0 font-weight-bold border-none"  style="color: #868686;cursor: pointer" data-toggle="modal" data-target="#VIEW-ALL-ASKS">VIEW ALL ASKS</button>
							</div>
						</div>
					</div>
					<div class="col-sm-8 col-md-3 ">
						<div class="d-flex flex-column justify-content-center single-item-padding-left-right">
							<div class="pb-2">
								<p class="mb-0" style="color: #888888;">HIGHEST BID:</p>
							</div>
							<div>
								<div class="card single-item-black-card sell_now_btn">
									<div class="card-body">
										<div class="d-flex flex-row justify-content-start">
											<div style="border-right: 1px white solid;padding-right: 8px;">
												<p class="mb-0">SELL</p>
												<p class="mb-0">NOW</p>
											</div>
											<div>
												<p class="h2 font-weight-bold mb-0 pl-xl-5 pl-lg-3 pl-md-2 max_bid single-item-padding-left-xs">£ -</p>
												<input type="hidden" class="highest_bid_in" >
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="d-flex flex-row justify-content-center pt-2">
								<button class="mb-0 font-weight-bold border-none "style="color: #868686;cursor: pointer" data-toggle="modal" data-target="#VIEW-ALL-BIDS">VIEW ALL BIDS</button>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-3">

					</div>
				</div>

				<div class="row pt-4 pb-4">
					<div class="col text-center">
					{{-- 	<p class="mb-0" style="color: #ACACAC">CONDITION:<span class="font-weight-bold pl-1 condition_dynamic">{{strtoupper($product->condition)}}</span> </p> --}}

						<p class="mb-0 condition_dropdown_p hide" style="color: #ACACAC">Other Condition Available:<span class="font-weight-bold pl-1"></span>
							<select class="text-white bg-dark mb-0 condition_dropdown ">
								<option value="">Please Choose</option>
								<option value="new">New</option>
								<option value="old">Old</option>
							</select>
							<div class="row ">
				        <div class="spinner_center">
					        <div class="spinner-grow spinner-grow-small spinner_ff hide" role="status">
					          <span class="sr-only">Loading...</span>
					        </div>
				    	</div>
			    	</div>
						</p>
					</div>
				</div>
			</section>

			<div class="row">
				<div class="col text-center">
					<p class="d-inline p-1" style="font-size: 20px;">RECENT SALE</p>
					<p class="d-inline p-1 recent_sale_set" style="font-size: 25px;">£ -</p>
					<img src="{{asset('assets\img\Image13.png')}}" class="d-inline p-1" style="font-size: 20px;">
				</div>
			</div>

			<div class="row pt-2 pb-5">
				<div class="col text-center">
					<p class="d-inline p-1" style="font-size: 18px;">DROPPED</p>
					<p class="d-inline p-1" style="font-size: 18px;">{{dateFormat($product->publish_date)}}</p>
				</div>
			</div>

			<div class="row text-center pt-3 pb-2">



				<div class="col-sm-12 col-md-3">

				</div>
				<div class="col-sm-12 col-md-3 m-2">
					<a href="javascript:void(0)" data-href="{{route('seller.bid.index',$product->id)}}"  class="btn shadow-sm border-0 btn-block place_bid_c "style="background-color: #EFEFEF;height: 60px; line-height: 50px">
						PLACE A BID
					</a>
				</div>
				<div class="col-sm-12 col-md-3 m-2">
					<a href="javascript:void(0)" data-href="{{route('seller.ask.index',$product->id)}}" class="btn shadow-sm border-0 btn-block place_ask_c"style="background-color: #EFEFEF;height: 60px; line-height: 50px">
						PLACE AN ASK
					</a>
				</div>
				<div class="col-sm-12 col-md-3">

				</div>
			</div>
			<div class="row  " style="padding-bottom: 6rem;">
				<div class="col text-center">
					<p class="mb-0 d-inline">ALL PAYMENTS PROTECTED THROUGH PAYPAL PROTECTION</p>
					<img class="d-inline pl-1" src="{{asset('assets\img\ic_vpn_lock_24px.png')}}">
				</div>
			</div>
			<div class="row text-center index-heading-line">
				<div class="col ">

				</div>
				<div class="col-sm-2 p-0">
					<hr class="index-hr-red">
				</div>
				<div class="col-sm-3 ">
					<p class="mb-0 font-weight-bold " style="font-size: 23px;">Related Product</p>
				</div>
				<div class="col-sm-2 p-0">
					<hr class="index-hr-black">
				</div>
				<div class="col ">

				</div>
			</div>

			<section class="p-4" style="background-color: #F2F2F2;margin-bottom: 6rem;">
				<div class="row pt-2">
					@foreach($related_products as $related_product)
						<div class="p-2 col-sm-12 col-md-4">
							 {{-- <a href="{{route('single_product',$related_product->id)}}" style="color:black"> --}}
								<div class="card border-0 shadow">
									<img src="{{asset(@$related_product->productImage->image_url)}}" class="card-img-top product_all_page_img" alt="...">
									<div class="card-body text-center">
										<p class="mb-0 ">{{$related_product->product_name}}</p>
										<div class="d-flex flex-row justify-content-center pt-3 pb-2">
											<div class="p-1">
												<p class="mb-0">LOWEST ASK</p>
											</div>
											<div class="p-1">
												@if($related_product->singleLowestAsk)
													<p class="mb-0 font-weight-bold">£  {{$related_product->singleLowestAsk->ask}}</p>
												@else
													<p class="mb-0 font-weight-bold">£ - </p>
												@endif

											</div>

										</div>
										<div class="d-flex flex-row justify-content-center ">
											<div class="p-1">
												<p class="mb-0">RECENT SALE</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold" style="color: #EA2126;">£ - </p>
											</div>

										</div>
									</div>

								</div>
							{{-- </a> --}}
						</div>
					@endforeach
				</div>
			</section>
			<div class="row text-center index-heading-line">
				<div class="col ">

				</div>
				<div class="col-sm-2 p-0">
					<hr class="index-hr-red">
				</div>
				<div class="col-sm-3 ">
					<p class="mb-0 font-weight-bold " style="font-size: 23px;">Last Sales</p>
				</div>
				<div class="col-sm-2 p-0">
					<hr class="index-hr-black">
				</div>
				<div class="col ">

				</div>
			</div>
			<style type="text/css">
						.ggg{
							background-color: #2F2F2F;width: 10rem; color: white
						}
						.ppp{
							background-color: #EFEFEF;height: 60px; line-height: 50px
						}
						.ppp.active {
							 background-color: #2F2F2F;
							 color: #ffffff
						}
					</style>
				<div class="d-flex py-2 justify-content-center">
					<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
					  <div class="btn-group mr-2" style="flex-wrap: wrap;" role="group" aria-label="First group">
					    <button type="button" onclick="GraphRenderDynamic(1)"  class="btn btn-sm btn_1_month ppp ee-1" style="">1M</button>
					    <button type="button" onclick="GraphRenderDynamic(3)" class="btn btn-sm ppp ee-3" >3M</button>
					    <button type="button" onclick="GraphRenderDynamic(6)"  class="btn  btn-sm ppp ee-6" >6M</button>
					    <button type="button" class="btn btn-sm  ppp" >YTD</button>
					    <button type="button" onclick="GraphRenderDynamic(12)"  class="btn btn-sm  ppp ee-12" >1Y</button>
					    <button type="button" onclick="GraphRenderDynamic(14)"  class="btn btn-sm  ppp ee-14" >ALL</button>
					  </div>
					</div>
				</div>
			<div class="row ">
		        <div class="spinner_center">
			        <div class="spinner-grow spinner-grow-small spinner_ffff hide" role="status">
			          <span class="sr-only">Loading...</span>
			        </div>
		    	</div>
	    	</div>

			<div class="row pb-5">
				<div class="col">
					<div id="chartContainer" style="height: 100%; width: 100%;">
						{{-- <canvas id="myChart" width="400" height="400"></canvas>
						    <div id="curve_chart" style="width: 900px; height: 500px"></div> --}}
						    <div id="chart_div"></div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 5rem;">
				<div class="col text-center">
					<button class="btn rounded-0 border-0 p-2 text-white shadow-none"  data-toggle="modal" data-target="#VIEW-ALL-SALES" onclick="getSales()" style="background-color: #2F2F2F;width: 10rem">
						VIEW ALL SALES
					</button>
				</div>
			</div>
    </div>

    <!-- Modal -->
	<div class="modal fade border-0" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-ASKS-Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header" STYLE="background-color: #000000;">
					<h5 class="modal-title text-white" id="exampleModalCenterTitle">SIZE</h5>
					<button type="button " class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						@if($product)
							@if($product->ProductSizes)
								@foreach($product->ProductSizes as $product_size)
									<div class="col-sm-12 col-md-6 p-2">
										<button class="btn shadow border-0 btn_model_size single-item-btn-modal p-3 btn-block ($product_size->productAskBySize) ? 'oo' : 'hide' " data-product_id = "{{@$product->id}}" data-size_id = "{{@$product_size->id}}" data-size="{{@$product_size->productTypeSize->name}}" data-id = "{{@$product_size->productTypeSize->id}}" data-dismiss="modal">
											<p class="mb-0 font-weight-bold h4" >{{@$product_size->productTypeSize->name}}</p>
											{{-- <p class="mb-0" >£295</p> --}}
										</button>
										<input type="hidden" name="product_size"  class="product_size_model">
									</div>
								@endforeach
							@endif
						@endif
					</div>
				{{-- 	<div class="row">
						<div class="col-sm-12 col-md-6 p-2">
							<button class="btn shadow border-0 single-item-btn-modal p-3 btn-block" data-dismiss="modal">
								<p class="mb-0 font-weight-bold h4" >L</p>
								<p class="mb-0" >£295</p>
							</button>
						</div>
						<div class="col-sm-12 col-md-6 p-2">
							<button class="btn shadow border-0 single-item-btn-modal p-3 btn-block" data-dismiss="modal">
								<p class="mb-0 font-weight-bold h4" >XL</p>
								<p class="mb-0" >£295</p>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-6 p-2">
							<button class="btn shadow border-0 single-item-btn-modal p-3 btn-block" data-dismiss="modal">
								<p class="mb-0 font-weight-bold h4" >XXL</p>
								<p class="mb-0" >£295</p>
							</button>
						</div>
						<div class="col-sm-12 col-md-6 p-2">
							<button class="btn shadow border-0 single-item-btn-modal p-3 btn-block" data-dismiss="modal">
								<p class="mb-0 font-weight-bold h4" >XXXL</p>
								<p class="mb-0" >£295</p>
							</button>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>

<!--	Modal View all asks-->
	<div class="modal fade border-0" id="VIEW-ALL-ASKS" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-ASKS-Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header" STYLE="background-color: #000000;">
					<h5 class="modal-title text-white" id="VIEW-ALL-ASKS-Title">ALL ASKS</h5>
					<button type="button " class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
						<table class="table " >
						<thead class="">
						<tr class="table-secondary">
							<th scope="col" class="font-weight-bold">Size</th>
							<th scope="col" class="font-weight-bold">Ask Price</th>
							{{-- <th scope="col" class="font-weight-bold">Available</th> --}}

						</tr>
						</thead>
						<tbody class="all_ask_table_body">


						</tbody>
					</table>
					<p class="align-center ask_tbl ">
						No Record Found...
					</p>
				</div>

			</div>
		</div>
	</div>

	<!--	Modal View all Bids-->
	<div class="modal fade border-0" id="VIEW-ALL-BIDS" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-BIDS-Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header" STYLE="background-color: #000000;">
					<h5 class="modal-title text-white" id="VIEW-ALL-BIDS-Title">ALL BIDS</h5>
					<button type="button " class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table " >
						<thead class="">
						<tr class="table-secondary">
							<th scope="col" class="font-weight-bold">Size</th>
							<th scope="col" class="font-weight-bold">Bid Price</th>
							{{-- <th scope="col" class="font-weight-bold">Available</th> --}}

						</tr>
						</thead>
						<tbody class="all_bid_table_body">

						</tbody>
					</table>
					<p class="align-center bid_tbl ">
						No Record Found...
					</p>
				</div>

			</div>
		</div>
	</div>

	<!--	Modal View all Bids-->
	<div class="modal fade border-0" id="VIEW-ALL-SALES" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-BIDS-Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header" STYLE="background-color: #000000;">
					<h5 class="modal-title text-white" id="VIEW-ALL-SALE-Title">All Sales</h5>
					<button type="button " class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row ">
				        <div class="spinner_center">
					        <div class="spinner-grow spinner-grow-small spinner_sales hide" role="status">
					          <span class="sr-only">Loading...</span>
					        </div>
				    	</div>
			    	</div>
			    	<div class="uuu">
						<table class="table " >
							<thead class="">
							<tr class="table-secondary">
								<th scope="col" class="font-weight-bold">Size</th>
								<th scope="col" class="font-weight-bold">Sale Price</th>
							</tr>
							</thead>
							<tbody class="all_sale_table_body">

							</tbody>
						</table>
						<div class="spinner_center">
					        <div class="spinner-grow spinner-grow-small spinner_sales_load_more hide" role="status">
					          <span class="sr-only">Loading...</span>
					        </div>
				    	</div>
						<input type="hidden" name="dd" class="url-sales">
						<button class="btn btn-block hide load_more_btn " data-url="" onclick="loadMore()" style="color: white;background: black">Load More</button>
						<p class="align-center sale_tbl ">
							No Record Found...
						</p>
					</div>
				</div>

			</div>
		</div>
	</div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@include('admin.js-css-blades.sweetalert')

@section('cssheader')
	<link rel="stylesheet" href="{{asset('css/mobirise-icons.css')}}">
	<link rel="stylesheet" href="{{asset('css/mbr-additional.css')}}" type="text/css">
@endsection
@section('jsfooter')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script> --}}
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		var size_id = 0;
		var product_id = 0;
		var limit = 10;
		$(document).ready(function(){
			var min_ask_in=$('.min_ask_in').val('');
			// console.log(min_ask_in);
			$('.highest_bid_in').val('');
			$('.btn_model_size').click(function(){
				$('.spinner_f').removeClass('hide');
			    $('.ask_tbl').addClass('hide');

				var id = $(this).data('id');
				var size = $(this).data('size');
				size_id = $(this).data('size_id');
				product_id = $(this).data('product_id');
				$('.size_id_gg').val(size_id);
				$(this).next('.product_size_model').val(id);
				$('.btn_size_body').html(''+size.toUpperCase()+'');
				var data = {
							size_id : size_id,
							product_id : product_id
						};
				$.ajax({
		          type: "POST",
		          url: "{{route('get_lowest_ask_bid')}}?limit="+limit,
		          data:data,
		          dataType: "JSON",
		          success: function (response) {
			          if(response.status == 1){
						$('.spinner_f').addClass('hide');
						if(response.total_new != "0" && response.total_old != "0" ){
							$('.condition_dropdown_p').removeClass('hide');
						}else{
							$('.condition_dropdown_p').addClass('hide');
						}
						console.log(response.min_ask.ask);
			          	if(response.min_ask.ask > 0){
			            	$('.product_ask_no').addClass('hide');
			            	$('.place_bid_hide').removeClass('hide');
			            	$('.min_ask').html('£ '+response.min_ask.ask);
			            	$('.min_ask_in').val(response.min_ask.ask);
			            	$('.condition_dynamic').html(response.min_ask.condition);
			            	$('.condition_check').val(response.min_ask.condition);
			            	var ht = '';
			            	$.each(response.asks,function(key,value){
			            		ht += '<tr><td>'+value.product_size.product_type_size.name.toUpperCase()+'</td>'+'<td>'+value.ask+'</td></tr>';
			            	});
			            	$('.all_ask_table_body').html(ht);
			            	$('.ask_tbl').addClass('hide');
			          	}else{
			            	$('.min_ask').html('£ -');
			            	$('.min_ask_in').val('');
			            	$('.all_ask_table_body').html('');
			            	$('.ask_tbl').removeClass('hide');
			            	$('.place_bid_hide').addClass('hide');
			            	$('.product_ask_no').removeClass('hide');
			            	$('.condition_dynamic').html(response.max_bid.condition);
			            	$('.condition_check').val(response.max_bid.condition);
			          	}
			          	if(response.max_bid.max_bid > 0){
			            	$('.max_bid').html('£ '+response.max_bid.max_bid);
			            	$('.highest_bid_in').val(response.max_bid.max_bid);

			            	var ht = '';
			            	$.each(response.bids,function(key,value){
			            		ht += '<tr><td>'+value.product_size.product_type_size.name.toUpperCase()+'</td>'+'<td>'+value.bid+'</td></tr>';
			            	});
			            	$('.all_bid_table_body').html(ht);
			            	$('.bid_tbl').addClass('hide');

			          	}else{
			            	$('.bid_tbl').removeClass('hide');
			          		$('.max_bid').html('£ -');
			          		$('.highest_bid_in').val('');
			          		$('.all_bid_table_body').html('');
			          	}
			          	if(response.recent_sale){
			          		$('.recent_sale_set').html('£ '+response.recent_sale.total_amount);
			          	}else{
			          		$('.recent_sale_set').html('£ -');
			          	}

			          	google.charts.load('current', {packages: ['corechart', 'line']});
						google.charts.setOnLoadCallback(drawBackgroundColor);

						function drawBackgroundColor() {
					      var data = new google.visualization.DataTable();
					      	var a = [[0,0,'0']];
					      	var da = [];
					      data.addColumn('number', 'X');
					      data.addColumn('number', 'SALES');
					       data.addColumn({type: 'string', role: 'tooltip'});
					       if(response.product_sales){
						       	$.each(response.product_sales.sales,function(index, value){
						       		var date = formatDate(new Date(value.d));
						       		date += '\n Sale Amount :: £ '+value.total
						       		var f = value.d;
									 a.push([(index+1),value.total,date]);
						       	});
						       	// var r = 0;
						       	// var er = [0,5,10,15,20,25,29];
						       	// for(var i = 1; i<=30; i++){
						       	// 	// if(er.indexOf(i) != '-1'){
							       // 		// var t = (i + 1);
							       // 		da.push({'v':i,'f':"'"+i+"'"});
								      //  	// r = r+1;
						       	// 	// }

						       	// }
					       }
					       console.log(da);
					        data.addRows(a);
					       var options = {
					        hAxis: {
					            title: 'Month',
					            tooltip: {isHtml: true},
					            // colors: ['black', 'red', 'green', 'yellow', 'gray'],
					            // legend: 'none',
					            // showTextEvery: 1,
					            ticks: da
					        },
					        colors: ['#040404'],
					        backgroundColor: '#f1f8e9',
					        chartArea: { width: 880 ,height:200},
					        curveType: 'function',
	          				pointSize: 5,
					   		}
					      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
					      chart.draw(data, options);
					      $('.ppp').removeClass('active');
					      $('.ee-1').addClass('active');
					    }
			          }
			          if(response.status == 0){

			          }
		          },
		          error: function(jqXHR, exception){
					if (jqXHR.status == 422) {
			              var html_error = '';
			              $.each(jqXHR.responseJSON.errors, function (key, value)
			              {
			                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
			              })
			              html_error += "</ul></div>";
			              $('.error_msg_e_c').html(html_error);

			              $(".alert ").css("max-width","none");
			            }
		        	}
		      	});
			});
		});
		$('.place_bid_c').click(function(){
			if($('.min_ask_in').val() != ""){
				window.location = $(this).data('href');
			}else{
				Swal.fire(
				  'Warning',
				  'Please check the size and condition',
				  'warning'
				);
			}
		});
		$('.place_ask_c').click(function(){
			if($('.min_ask_in').val() != ""){
				window.location = $(this).data('href');
			}else{
				Swal.fire(
				  'Warning',
				  'Please check the size and condition',
				  'warning'
				);
			}
		});
		$('.condition_dropdown').change(function(){
			$('.condition_check').val($(this).val());
			 $('.spinner_ff').removeClass('hide');
			$('.condition_dynamic').html($(this).val());
			 $.ajax({
		          type: "get",
		          url: "{{route('set_condition')}}?condition="+$(this).val(),
		          dataType: "JSON",
		          success: function (response) {

		          	var data = {
							size_id : size_id,
							product_id : product_id
						};
					$.ajax({
			          type: "POST",
			          url: "{{route('get_lowest_ask_bid_condition')}}",
			          data:data,
			          dataType: "JSON",
			          success: function (response) {
				          if(response.status == 1){
							$('.spinner_ff').addClass('hide');
							if(response.total_new != "0" && response.total_old != "0" ){
								$('.condition_dropdown_p').removeClass('hide');
							}else{
								$('.condition_dropdown_p').addClass('hide');
							}
				          	if(response.min_ask.ask > 0){
				            	$('.product_ask_no').addClass('hide');
				            	$('.place_bid_hide').removeClass('hide');
				            	$('.min_ask').html('£ '+response.min_ask.ask);
				            	$('.min_ask_in').val(response.min_ask.ask);
				            	$('.condition_dynamic').html(response.min_ask.condition);
				            	$('.condition_check').val(response.min_ask.condition);
				            	var ht = '';
				            	$.each(response.asks,function(key,value){
				            		ht += '<tr><td>'+value.product_size.product_type_size.name.toUpperCase()+'</td>'+'<td>'+value.ask+'</td></tr>';
				            	});
				            	$('.all_ask_table_body').html(ht);
				            	$('.ask_tbl').addClass('hide');
				          	}else{
				            	$('.min_ask').html('£ -');
				            	$('.min_ask_in').val('');
				            	$('.all_ask_table_body').html('');
				            	$('.ask_tbl').removeClass('hide');
				            	$('.place_bid_hide').addClass('hide');
				            	$('.product_ask_no').removeClass('hide');

				          	}
				          	if(response.max_bid > 0){
				            	$('.max_bid').html('£ '+response.max_bid);
				            	$('.highest_bid_in').val(response.max_bid);
				            	var ht = '';
				            	$.each(response.bids,function(key,value){
				            		ht += '<tr><td>'+value.product_size.product_type_size.name.toUpperCase()+'</td>'+'<td>'+value.bid+'</td></tr>';
				            	});
				            	$('.all_bid_table_body').html(ht);
				            	$('.bid_tbl').addClass('hide');

				          	}else{
				            	$('.bid_tbl').removeClass('hide');
				          		$('.max_bid').html('£ -');
				          		$('.highest_bid_in').val('');
				          		$('.all_bid_table_body').html('');
				          	}
				          }
				          if(response.status == 0){

				          }
			          },
			          error: function(jqXHR, exception){
						if (jqXHR.status == 422) {
				              var html_error = '';
				              $.each(jqXHR.responseJSON.errors, function (key, value)
				              {
				                html_error +='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+value+'</div></div>';
				              })
				              html_error += "</ul></div>";
				              $('.error_msg_e_c').html(html_error);

				              $(".alert ").css("max-width","none");
				            }
			        	}
			      	});
		          }
		      });
		});
		$('.buy_now_btn').click(function(){
			if($('.min_ask_in').val() != ""){
				window.location = "{{route('seller.buy.product_size',$product->id)}}?size_id="+size_id;
			}else{
				Swal.fire(
				  'Warning',
				  'Please check the size and condition',
				  'warning'
				);
			}
		});
		$('.sell_now_btn').click(function(){

			if($('.highest_bid_in').val() != ""){
				window.location = "{{route('seller.sell.product_size',$product->id)}}?size_id="+size_id;
			}else{
				Swal.fire(
				  'Warning',
				  'Please check the size and condition',
				  'warning'
				);
			}
		})

		function formatDate(date) {
		  var monthNames = [
		    "January", "February", "March",
		    "April", "May", "June", "July",
		    "August", "September", "October",
		    "November", "December"
		  ];

		  var day = date.getDate();
		  var monthIndex = date.getMonth();
		  var year = date.getFullYear();

		  return day + ' ' + monthNames[monthIndex] + ' ' + year;
		}

		function GraphRenderDynamic(aa){
			$('.ppp').removeClass('active');
			$('.ee-'+aa).addClass('active');
			var size_id = $('.size_id_gg').val();
			var product_id = $('.product_id_gg').val();
			$('.spinner_ffff').removeClass('hide');
			$.ajax({
		          type: "GET",
		          url: "{{route('get-graph-data')}}?product_id="+product_id+"&product_size_id="+size_id+"&filter="+aa,

		          dataType: "JSON",
		          success: function (response) {
		          	$('.spinner_ffff').addClass('hide');
		          	console.log(response.product_sales);
		          	google.charts.load('current', {packages: ['corechart', 'line']});
					google.charts.setOnLoadCallback(drawBackgroundColor);
					function drawBackgroundColor() {
				      var data = new google.visualization.DataTable();
				      	var a = [[0,0,'0']];
				      	var da = [];
				      data.addColumn('number', 'X');
				      data.addColumn('number', 'SALES');
				      data.addColumn({type: 'string', role: 'tooltip'});
				       if(response.product_sales){
					       	$.each(response.product_sales,function(index, value){
					       		var date = formatDate(new Date(value.d));
					       		date += '\n Sale Amount :: £ '+value.total
					       		var f = value.d;
								 a.push([(index+1),value.total,date]);
					       	});
					       // 	if(aa == 14){
					       // 		da.push({'v':0,'f':"Jan"});
					       // 		da.push({'v':1,'f':"Feb"});
					       // 		da.push({'v':2,'f':"Mar"});
					       // 		da.push({'v':3,'f':"Apr"});
					       // 		da.push({'v':4,'f':"May"});
					       // 		da.push({'v':5,'f':"Jun"});
					       // 		da.push({'v':6,'f':"Jul"});
					       // 		da.push({'v':7,'f':"Aug"});
					       // 		da.push({'v':8,'f':"Sep"});
					       // 		da.push({'v':9,'f':"Oct'"});
					       // 		da.push({'v':10,'f':"Nov"});
					       // 		da.push({'v':11,'f':"Dec'"});
					       // 	}else{
					       // 		var r = 0;
						      //  	var er = [0,5,10,15,20,25,29];
						      //  	for(var i = 1; i<=30; i++){
						      //  		// if(er.indexOf(i) != '-1'){
							     //   		// var t = (i + 1);
							     //   		da.push({'v':i,'f':"'"+i+"'"});
								    //    	// r = r+1;
						      //  		// }

						      //  	}
					       // }
				       }
				       console.log(da);
				        data.addRows(a);
				       var options = {
				        hAxis: {
				            title: 'Month',
				            tooltip: {isHtml: true},
				            // colors: ['black', 'red', 'green', 'yellow', 'gray'],
				            // legend: 'none',
				            // showTextEvery: 1,
				            ticks: da
				        },
				        colors: ['#040404'],
				        backgroundColor: '#f1f8e9',
				        chartArea: { width: 880 ,height:200},
				        curveType: 'function',
          				pointSize: 5,


				   		}
				      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

				      chart.draw(data, options);
				    }
		          }
		      })
		}

		function getSales(){

			var size_id = $('.size_id_gg').val();
			var product_id = $('.product_id_gg').val();
			// $('.spinner_').removeClass('hide');
			if(product_id.length > 0 && size_id.length > 0){
				$('.spinner_sales').removeClass('hide');
				$('.uuu').addClass('hide');
				$.ajax({
			          type: "GET",
			          url: "{{route('get-sales-data')}}?product_id="+product_id+"&product_size_id="+size_id,

			          dataType: "JSON",
			          success: function (response) {
						if(response.product_sale_limit.data.length > 0){
			          		var ht = '';
			            	$.each(response.product_sale_limit.data,function(key,value){
			            		ht += '<tr><td>'+value.product_size.product_type_size.name.toUpperCase()+'</td>'+'<td>'+value.total+'</td></tr>';
			            	});
			            	$('.all_sale_table_body').html(ht);

			            	if(response.product_sale_limit.next_page_url){
			            		console.log(response.product_sale_limit.next_page_url);
			            		var a ;
			            		a = response.product_sale_limit.next_page_url+"&product_id="+product_id+"&product_size_id="+size_id;

 			            		$('.url-sales').val(a);
 			            		$('.load_more_btn').removeClass('hide');
			            	}else{
			            		$('.load_more_btn').addClass('hide');
			            	}

			            	$('.sale_tbl').addClass('hide');
			          	}else{

			          		$('.all_sale_table_body').html('');
			            	$('.sale_tbl').removeClass('hide');
			          	}
			          	$('.spinner_sales').addClass('hide');
						$('.uuu').removeClass('hide');
			          }
			    });
			}
		}
		function loadMore(){
			// $('.spinner_').removeClass('hide');

				$('.spinner_sales_load_more').removeClass('hide');
				// $('.uuu').addClass('hide');
				var url = $('.url-sales').val();

				$.ajax({
			          type: "GET",
			          url: url,
			          dataType: "JSON",
			          success: function (response) {
						if(response.product_sale_limit.data.length > 0){
			          		var ht = '';
			            	$.each(response.product_sale_limit.data,function(key,value){
			            		ht += '<tr><td>'+value.product_size.product_type_size.name.toUpperCase()+'</td>'+'<td>'+value.total+'</td></tr>';
			            	});
			            	$('.all_sale_table_body').append(ht);

			            	if(response.product_sale_limit.next_page_url){
			            		var a ;
			            		a = response.product_sale_limit.next_page_url+"&product_id="+product_id+"&product_size_id="+size_id;

 			            		$('.url-sales').val(a);
 			            		$('.load_more_btn').removeClass('hide');
			            	}else{
			            		$('.load_more_btn').addClass('hide');
			            	}
			            	$('.sale_tbl').addClass('hide');
			          	}else{
			          		$('.all_sale_table_body').html('');
			            	$('.sale_tbl').removeClass('hide');
			          	}
			          	$('.spinner_sales_load_more').addClass('hide');
						// $('.uuu').removeClass('hide');
			          }
			    });
		}



	google.charts.load('current', {packages: ['corechart', 'line']});
	google.charts.setOnLoadCallback(drawBackgroundColor);

	function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('number', 'X');
      data.addColumn('number', 'SALES');
       data.addRows([
        [0, 0]
      ]);
      var options = {
        hAxis: {
          title: 'SALES'
        },
        vAxis: {
          title: 'SALES'
        },
        backgroundColor: '#f1f8e9',
        chartArea: { width: 880 ,height:200},
      };
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }


 //    google.charts.load('current', {packages: ['corechart', 'line']});
	// google.charts.setOnLoadCallback(drawBackgroundColor);

	// function drawBackgroundColor() {
 //      var data = new google.visualization.DataTable();
 //      	var a = [[0,0,'0']];
 //      	var da = [];
 //      data.addColumn('number', 'X');
 //      data.addColumn('number', 'SALES');
 //       data.addColumn({type: 'string', role: 'tooltip'});
 //       	var r = 0;
 //       	var er = [0,5,10,15,20,25,29];
 //       	for(var i = 1; i<=30; i++){
 //       		// if(er.indexOf(i) != '-1'){
	//        		// var t = (i + 1);
	//        		da.push({'v':i,'f':"'"+i+"'"});
	// 	       	// r = r+1;
 //       		// }

 //       	}
 //       // }
 //        data.addRows(a);
 //       var options = {
 //        hAxis: {
 //            title: 'Month',
 //            tooltip: {isHtml: true},
 //            legend: 'none',
 //            // showTextEvery: 1,
 //            ticks: da
 //        }
 //   		}
 //      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
 //      chart.draw(data, options);
 //    }
	</script>

@endsection
