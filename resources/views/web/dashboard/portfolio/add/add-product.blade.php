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
								@include('flash::message')
								@if (count($errors) > 0)
									<div class="alert alert-danger errors-container">
									  <ul>
 										@foreach($errors->all() as $error)
									      <li> {{ $error }}</li>
									    @endforeach
									  </ul>
									</div>
								@endif
								<p class="mb-0">{{$product->product_name}}</p>
							</div>
						</div>
						<div class="row pt-3 pb-3">
							<div class="col text-center">
								<P class="mb-0 d-inline pr-2" style="color: #8D8D8D;vertical-align: middle;">SIZE</p>
								<button class="btn p-2 rounded-0 text-white bg-dark shadow-none btn_size_show" data-toggle="modal" data-target="#exampleModalCenter"
									   style="width: 5rem;border: 2px white solid;padding: 3px !important;">-
								</button>
							</div>
						</div>
					<form method="post" action="{{route('seller.portfolio.save')}}">
						@csrf
						<section class="pt-2 pb-2" style="background-color: #F8F8F8;">
						<input type="hidden" name="product_id" value="{{$product->id}}">


						<div class="row  pb-1 ">
							
						</div>
						<div class="row  pb-1 ">
							<div class="col "> 
									<div class="form-group row m-0">
										<div class="col-sm-2">

										</div>
										<label for="staticBid" class="col-sm-3 col-form-label text-left" style="color: #8D8D8D;font-size: 14px;">CONDITION</label>
										<div class="col-sm-5 mt-auto mb-auto">
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" checked="" id="NEW" value="new" {{ old('condition') == 'new' ? 'checked' : ''}} required=""  name="condition" class="custom-control-input">
												<label class="custom-control-label" for="NEW">NEW</label>
											</div>
											{{-- <div class="custom-control custom-radio custom-control-inline">
												<input type="radio" id="OLD" {{ old('condition') == 'old' ? 'checked' : ''}} value="old" required="" name="condition" class="custom-control-input">
												<label class="custom-control-label" for="OLD">OLD</label>
											</div> --}}
										</div>
										<div class="col-sm-2">

										</div>
									</div> 
									<div class="form-group row pt-3">
										<div class="col-sm-2">
											<input type="hidden" name="size" class="product_size_id">
											<input type="hidden" name="day" class="day_f">
											<input type="hidden" name="month" class="month_f">
											<input type="hidden" name="year" class="year_f">
										</div>
										<label for="staticBid" class="col-sm-3 text-left col-form-label mt-auto mb-auto" style="color: #8D8D8D;font-size: 14px;">PURCHASE PRICE</label>
										<div class="col-sm-4 mt-auto mb-auto">
											<input type="text" value="{{old('price')}}" class="form-control-plaintext place-a-bid-amount-text-field" id="staticBid" name ="price"  required="" 
												  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>
										<div class="col-sm-2">

										</div>
									</div> 
							</div>
						</div>

						<div class="row pt-3 pb-3">
							<div class="col ">
								<form class="m-2">
									<div class="form-group row m-0">
										<div class="col-sm-2">

										</div>
										<label for="staticBid" class="col-sm-3 col-form-label text-left" style="color: #8D8D8D;font-size: 14px;">PURCHASE DATE</label>
										<div class="col-sm-7 mt-auto mb-auto ">
											<div class="row">
												 
												<input type="hidden" name="dd" class="dd">
												<div class="col-sm-12 col-md-12 col-lg-6">
													 
												</div>
												<div class="col-sm-12 col-md-12 col-lg-6">
													 
												</div>
											</div>




										</div>
										<div class="col-sm-2">

										</div>
									</div>
								</form>
							</div>
						</div>


						<input type="hidden" name="size_name" class="size_name_e">
						<div class="row">
							<div class="col text-center">
								<button class="btn p-2 rounded-0 text-white bg-dark shadow-none" style="width: 12rem;border: 2px white solid;">ADD TO PORTFOLIO</button>
							</div>
						</div>


					</section>
				</form>
					
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
						@foreach($product->ProductSizes as $product_size)
                                        
							<div class="col-sm-12 col-md-6 p-2">
								<button class="btn shadow border-0 btn_model_size single-item-btn-modal p-3 btn-block " data-product_id = "{{@$product->id}}" data-size_id = "{{@$product_size->id}}" data-size="{{@$product_size->productTypeSize->name}}" data-id = "{{@$product_size->productTypeSize->id}}" data-dismiss="modal">
									<p class="mb-0 font-weight-bold h4" >{{@$product_size->productTypeSize->name}}</p>
									{{-- <p class="mb-0" >£295</p> --}}
								</button>
								
							</div>
						@endforeach
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
			$('.size_name_e').val(size)
			$('.product_size_id').val(size_id);
		});
		$(".dd").dateDropdowns({
			monthFormat: "short",
		});
		$('.year').addClass('p-2 rounded-0 text-white bg-dark shadow-none');
		$('.day').addClass(' p-2 rounded-0 text-white bg-dark shadow-none');
		$('.month').addClass(' p-2 rounded-0 text-white bg-dark shadow-none');
		$('.day').change(function(){
			$('.day_f').val($(this).val());
		});
		$('.month').change(function(){
			$('.month_f').val($(this).val());
		});
		$('.year').change(function(){
			$('.year_f').val($(this).val());
		});
	</script>
@endsection