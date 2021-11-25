@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content" class="">
		<section class="selling-single-item-section">
			<div class="row">
				<div class="col">
					<button class="btn btn-default shadow-none  border-0 p-0" style="font-size: 22px;">
						{{-- <i class="fas fa-times"></i> --}}
					</button>
				</div>
			</div>
			<div class="row">
				 <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center text-center p-2">
					<section class="carousel slide cid-ruv1vrquBa" data-interval="false" data-ride="false" id="slider2-0">
						<div class="container content-slider">
							<div class="content-slider-wrap">
								<div>
									<div class="mbr-slider slide carousel" data-pause="true" data-keyboard="false" data-ride="false" data-interval="false">
										<ol class="carousel-indicators">
											@foreach($product_sale->product->productImages as $key => $product_images)
											<li data-app-prevent-settings="" data-target="#slider2-0" data-slide-to="{{$key}}"></li>
											@endforeach
										</ol>
										<div class="carousel-inner" role="listbox">
											@foreach($product_sale->product->productImages as $key => $product_images)
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
					@include('flash::message')
					<div class="row">

						<div class="col">
							<p class="mb-0 font-weight-bold" style="font-size: 18px">{{characterLimit($product_sale->product->product_name,20)}}</p>
						</div>
					</div>
					<div class="row pt-4 pb-4">
						<div class="col">
							<div class="p-2 shadow text-center text-white" style="background-color: #2F2F2F;width: 15rem;">
								<p class="d-inline mb-0 font-weight-bold h4">£ {{$product_sale->total_amount}}</p>
								<p class="d-inline mb-0 pl-2 " style="font-size: 13px;">excl. delivery</p>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="d-flex flex-row justify-content-start">

								@if($product_sale->product_status == 'received')
								<div class="d-flex flex-column justify-content-center">
									<p class="mb-0 font-weight-bold">Buyer Rating to You:</p>
								</div>
								<div class="d-flex flex-column justify-content-center pl-3">
									<div>
										<button class="btn btn-default shadow-none border-0 p-0" data-toggle="modal" data-target="">
											<div class="d-flex flex-row justify-content-center">
												@for($i = 1; $i<=5; $i++)
													@if(sellerRate($product_sale->delivery_rating,$product_sale->expected_rating,$product_sale->satisfaction_rating) >= $i)
														<i class="fas fa-star"></i>
													@else
														<i class="fas fa-star color-rate"></i>
													@endif
												@endfor
											</div>
										</button>
									</div>
									<div>
										<p class="mb-0 font-weight-bold" style="color: #989898;">{{characterLimitNotDot($product_sale->buyer->first_name.' '.$product_sale->buyer->last_name, 3)}} ***** {{substr($product_sale->buyer->first_name.' '.$product_sale->buyer->last_name, -1)}}</p>
									</div>
								</div>

								@endif
							</div>
						</div>
					</div>
					<div class="row pt-3 pb-3">
						<div class="col">
							<p class="mb-0 d-inline">SIZE:</p>
							<p class="mb-0 d-inline font-weight-bold pl-1">{{ucfirst($product_sale->productSize->productTypeSize->name)}}</p>
						</div>
					</div>
					<div class="row pt-3 pb-3">
						<div class="col">
							<p class="mb-0 d-inline">Condition:</p>
							<p class="mb-0 d-inline font-weight-bold pl-1">{{ucfirst($product_sale->condition)}}</p>
						</div>
					</div>
					<div class="row pb-3">
						<div class="col">
							<img class="d-inline " src="{{asset('assets/img/icons/Ellipse 9.png')}}">
							<p class="d-inline mb-0 pl-1">
								@if($product_sale->product_status == 'pending')
									Pending Delivery
								@elseif($product_sale->product_status == 'delivered')
									Successfully Shipped
								@elseif($product_sale->product_status == 'received')
									Received
								@elseif($product_sale->product_status == 'denied')
									Deneid
								@endif
							</p>
						</div>
					</div>
					<div class="p-3 mb-3" style="border: 1px #C9C9C9 solid">
						<div class="d-flex flex-row justify-content-between">
							<div>
								<p class="mb-0 font-weight-bold h4"> £ {{$product_sale->total_amount}}</p>
							</div>
							<div>

							</div>
						</div>
						<div class="d-flex flex-row justify-content-between pt-2 ">
							<div>

								<p class="mb-0 ">Payment Protection ({{$setting->value}} %)</p>

							</div>
							<div>
								<p class="d-inline mb-0">-</p>
								<p class="d-inline mb-0">£ {{$product_sale->transaction_fee}}</p>
							</div>
						</div>
					</div>

					<div class="p-3" style="border: 2px #2F2F2F solid">
						<div class="d-flex flex-row justify-content-between">
							<div>
								<P class="mb-0">Style</p>
							</div>
							<div>

								<p class="mb-0 font-weight-bold">{{$product_sale->product->style}}</p>
							</div>
						</div>
						<div class="d-flex flex-row justify-content-between pt-2">
							<div>
								<p class="mb-0 ">Purchased Date</p>
							</div>
							<div>

								<p class="mb-0 font-weight-bold">{{dateFormat($product_sale->product->created_at)}}</p>
							</div>

						</div>

					</div>
					@if($product_sale->product_status == 'pending')
						<div class="mt-3 p-2 shadow text-center text-white" style="background-color: #2F2F2F;width: 15rem;">
								<a href="{{route('seller.selling.deliver_product',[$product_sale->id])}}" style="color:white;">
									MARK AS Shipped
								</a>

						</div>
					@endif
				</div>
			</div>
		</section>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content rounded-0">
				<div class="modal-header text-white rounded-0" style="background-color: #000000;">
					<h5 class="modal-title" id="exampleModalCenterTitle">RATE</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-0">
					<div class="card border-0 rounded-0 shadow-sm text-center p-2" style="background-color: #F3F3F3">
						<div class="card-body p-0">
							<p class="mb-0 h5 font-weight-bold">
								Ronnie Rivera
							</p>
							<div class="d-inline d-flex flex-row justify-content-center">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
							</div>
							<p class="mb-0 d-inline font-weight-bold pl-2">(5.0)</p>
						</div>
					</div>
					<div class="card border-0 rounded-0 shadow-sm text-center mt-4 p-2" style="background-color: #F3F3F3">
						<div class="card-body p-0">
							<div class="d-flex flex-row justify-content-between">
								<div class="p-2 ">
									<p class="mb-0">Delivery Time</p>
								</div>
								<div class="p-2 ">

									<div class="d-inline d-flex flex-row justify-content-center">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
									</div>

								</div>
							</div>


						</div>
					</div>
					<div class="card border-0 rounded-0 shadow-sm text-center mt-3 p-2" style="background-color: #F3F3F3">
						<div class="card-body p-0">
							<div class="d-flex flex-row justify-content-between">
								<div class="p-2 ">
									<p class="mb-0">Item As Expected</p>
								</div>
								<div class="p-2 ">

									<div class="d-inline d-flex flex-row justify-content-center">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
									</div>

								</div>
							</div>


						</div>
					</div>
					<div class="card border-0 rounded-0 shadow-sm text-center mt-3 p-2" style="background-color: #F3F3F3">
						<div class="card-body p-0">
							<div class="d-flex flex-row justify-content-between">
								<div class="p-2 ">
									<p class="mb-0">Overall Statisfaction</p>
								</div>
								<div class="p-2 ">

									<div class="d-inline d-flex flex-row justify-content-center">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
									</div>

								</div>
							</div>


						</div>
					</div>
				</div>
				<div class="p-4 text-white border-0">
					<div class="text-center">
						<button type="button" class="btn shadow p-1 text-white text-center rounded-0" style="width: 10rem;background-color: #2F2F2F;">RATE
						</button>
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

@endsection
