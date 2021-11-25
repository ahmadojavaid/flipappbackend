@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
         <div class="container">
			<div class="row pt-5 " style="padding-bottom: 7rem;">
				<div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center text-center p-2">
					{{-- <div class="d-flex flex-row justify-content-center">
						<img src="./img/products/Screenshot%202019-07-13%20at%2016.16.24.png" class="place-a-bid-img">
					</div> --}}
					{{-- <div id="carouselExampleControls" class="carousel slide  " data-ride="carousel">
						<div class="carousel-inner">
							@foreach($product->productImages as $key => $product_images)
								<div class="carousel-item {{($key == 0) ? 'active' : ''}}">
								  <img src="{{asset($product_images->image_url)}}" class="  img-fluid">
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
						</div>
					</section>

				</div>
				<div class="col-sm-12 col-md-6 p-2">
					<div class="row">
							
							<div class="col-sm-12 col-md-12 text-center">
								 
								 
							</div>
						</div>
						<div class="row pt-3 pb-3">
							 
						</div>
					{{-- <form method="post" action="{{route('seller.portfolio.save')}}"> --}}
						@csrf
						<section class="pt-4 pb-4" style="background-color: #F8F8F8;">
							<div class="row">
								<div class="col-sm-12 col-md-12 text-center">
									<p class="mb-0">{{$product->product_name}}</p>
								</div>
							</div>
							<div class="row ">
								<div class="col-sm-8 col-md-8 m-auto">
									<div class="p-3 m-1 text-white" style="background-color: #2F2F2F;">
										<div class="d-flex flex-row justify-content-between">
											<div class="p-1">
												<p class="mb-0" style="font-size: 15px;">SIZE</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold">{{session('product_size_name')}}</p>
											</div>
										</div>
										<hr class="bg-white">
										<div class="d-flex flex-row justify-content-between">
											<div class="p-1">
												<p class="mb-0" style="font-size: 15px;">MARKET VALUE</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold">£ {{getRetailPriceBySize(session('product_size_id'))}}</p>
											</div>
										</div>
										<hr class="bg-white">
										<div class="d-flex flex-row justify-content-between">
											<div class="p-1">
												<p class="mb-0" style="font-size: 15px;">PURCHASE DATE</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold">{{session('purchase_date')}}</p>
											</div>
										</div>
										<hr class="bg-white">
										<div class="d-flex flex-row justify-content-between">
											<div class="p-1">
												<p class="mb-0" style="font-size: 15px;">PURCHASE PRICE</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold">£ {{session('purchase_price')}}</p>
											</div>
										</div>
										<hr class="bg-white">
										<div class="d-flex flex-row justify-content-between">
											<div class="p-1">
												<p class="mb-0" style="font-size: 15px;">CONDITION</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold">{{ucfirst(session('condition'))}}</p>
											</div>
										</div>
										<hr class="bg-white">
										<div class="d-flex flex-row justify-content-between">
											<div class="p-1">
												<p class="mb-0" style="font-size: 15px;">GAIN / LOSS</p>
											</div>
											<div class="p-1">
												<p class="mb-0 font-weight-bold"> £ {{(int)getRetailPriceBySize(session('product_size_id')) - (int)session('purchase_price')}}</p>
											</div>
										</div>
									</div>
									<div class="mt-3 mb-3 text-center">
									<button class="btn text-center  p-2 rounded-0 text-white  shadow-none"
										   style="background-color: #969696; width: 10rem;height: 3rem; border: 2px white solid;padding: 3px !important;">VIEW PRODUCT
									</button>
									</div>
									<div class="row pt-2">
										<div class="col-sm-12 col-md-12 col-lg-6 text-center">
											<a href="{{route('seller.portfolio.place_ask')}}" class="btn p-2 rounded-0 text-white bg-dark  shadow-none"
												   style=" width: 10rem;height: 3rem; border: 2px white solid;padding: 3px !important;">PLACE ASK
											</a>
										</div>
										<div class="col-sm-12 col-md-12 col-lg-6 text-center">
											<a href="{{route('seller.portfolio.place_ask',$product->id)}}" class="btn p-2 rounded-0 text-white bg-dark  shadow-none"
												   style=" width: 10rem;height:3rem;border: 2px white solid;padding: 3px !important;">SELL NOW
											</a>
										</div>
									</div>
								</div>
							</div>

						</section>
				{{-- </form> --}}
					
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
						
					</div>
				 
				</div>
			</div>
		</div>
	</div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
	<link rel="stylesheet" href="{{asset('css/mobirise-icons.css')}}">
	<link rel="stylesheet" href="{{asset('css/mbr-additional.css')}}" type="text/css">
@endsection
@section('jsfooter')
	<script src="{{asset('js/jquery.date-dropdowns.js')}}"></script>

	<script type="text/javascript">
		$('.btn_model_size').click(function(){
			var size = $(this).data('size');
			var size_id = $(this).data('size_id');
			$('.btn_size_show').html(size);
			$('.product_size_id').val(size_id);
		});
		$(".dd").dateDropdowns({
			monthFormat: "short",
		});
		$('.year').addClass('hide');
		$('.day').addClass(' p-2 rounded-0 text-white bg-dark shadow-none');
		$('.month').addClass(' p-2 rounded-0 text-white bg-dark shadow-none');
		$('.day').change(function(){
			$('.day_f').val($(this).val());
		});
		$('.month').change(function(){
			$('.month_f').val($(this).val());
		});
	</script>
@endsection