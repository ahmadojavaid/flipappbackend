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
					
						<section class="pt-2 pb-2" style="background-color: #F8F8F8;">
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
									<button class="btn p-2 rounded-0 text-white bg-dark shadow-none btn_size_body" data-toggle="modal" data-target="#exampleModalCenter"
										   style="width: 5rem;border: 2px white solid;padding: 3px !important;">{{ucfirst($product_ask->productSize->productTypeSize->name)}}
									</button>
								</div>
							</div>
							<form method="post" action="{{route('seller.ask.update')}}">
								@csrf
								<input type="hidden" value="" name="ff" class="is_exist_already">
								<input type="hidden" name="product_id" value="{{$product_ask->product_id}}">
								<input type="hidden" name="ask_id" value="{{$product_ask->id}}">
								<div class="p-1 place-a-bid-current-highest">
									<div class="row ask_t_p ">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Lowest Ask:</p>
											<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic"> {{$product_ask->getLowestAsk($product_ask->product_id,$product_ask->product_size_id,$product_ask->seller_id)}} </p>
										</div>
									</div>
									<div class="row already_ask hide">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Sorry! You can't place a ask, Because you have already place a Ask.</p> 
										</div>
									</div>
								</div>

								<div class="row pt-3 pb-1 ">
									<div class="col "> 
											<div class="form-group row">
												<div class="col-sm-2">

												</div>
												<label for="staticBid" class="col-sm-3 col-form-label">PLACE ASK:</label>
												<div class="col-sm-5">
													<input type="text" value="{{$product_ask->ask}}" required="" autocomplete="off" name="ask" class="form-control-plaintext place-a-bid-amount-text-field place_ask_input" id="staticBid"
														  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
												</div>
												<div class="col-sm-2">

												</div>
											</div> 
									</div>
								</div>
								<section class="p-2 place-a-bid-font-size" style="background-color: #F3F3F3;">
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>Shipping</p>
										</div>
										<div class="p-2">
											<p class="mb-0 d-inline"></p>
											<p class="mb-0 d-inline">{{($shipment_fee->value) ? '£ '.$shipment_fee->value .' (Exclusive)' : 'To Be Calculated'}}</p>
										</div>
									</div> 
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>Transaction Fee ({{@$setting->value}}%)</p>
											<input type="hidden" name="paypal_fee_dynamic" value="{{@$setting->value}}" class="paypal_fee_dynamic">
										</div>
										<div class="p-2">
											<p class="mb-0 d-inline">-</p>
											<p class="mb-0 d-inline paypal_fee_dynamic_cal">£ {{$product_ask->transaction_fee}}</p>
										</div>
									</div>
									<input type="hidden" name="product_size" value="{{$product_ask->product_size_id}}"  class="product_size_model">
									<div>
										<hr class="m-0">
									</div>
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p class="mb-0 font-weight-bold">Total:</p>
										</div>
										<div class="p-2">
											<input type="hidden" value="{{$product_ask->total}}" name="total" class="total_hi">
											<p class="mb-0 font-weight-bold total_ask_dynamic_cal ">£ {{$product_ask->total}}</p>
										</div>
									</div>

								</section>
								<div class="row pt-3 pb-2">
									@if($product_ask->ask_status == 'inactive')
										<div class="col">
											<div class="d-flex flex-row justify-content-center place-a-bid-font-size ">
												<div class="p-2 ">
													<p class="mb-0 font-weight-bold pr-2">ASK EXPIRES IN:</p>
												</div>

												<div class="p-2 place-a-bid-expire shadow">
													  <select name="expiry_day" required="">
													  	@for($i=1; $i<60; $i++)
													  		<option {{(dateDiffInDays($product_ask->expires_at) == $i) ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
													  	@endfor
													  </select>

													  {{-- <input type="number" name="expiry_date" required=""> --}}
												</div>
												<div class="p-2 ">
													Days<i class="far fa-clock pl-1"></i>
												</div>
												
											</div>
											@if(dateDiffInDays($product_ask->expires_at) == 0)
											  		<div class="d-flex flex-row justify-content-center place-a-bid-font-size  p-2 badge bg-soft-danger text-danger mb-3 shadow-none m-r-5">Expire. Please Choose days</div>
												@endif
										</div>
									@endif

								</div>
								<div class="row p-2">
									<div class="col text-center">
										<div class="custom-control custom-checkbox mr-sm-2">
											<input type="checkbox" checked="" class="custom-control-input term_check" name="term_condition" id="customControlAutosizing">
											<label class="custom-control-label mb-0 place-a-bid-font-size" for="customControlAutosizing">I AGREE TO THE TERMS AND CONDITIONS</label>
										</div>

									</div>
								</div>
								<div class="row">
									<div class="col text-center">
										<button   type="submit" class="btn p-2 rounded-0 text-white bg-dark shadow-none " style="width: 10rem;border: 2px white solid;">PLACE ASK
										</button>
									</div>
								</div>
							</form>

						</section>
					
				</div>
			</div>
		</div>
		<!-- Modal -->
		{{-- <div class="modal fade border-0" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-ASKS-Title" aria-hidden="true">
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
									</button>
									
								</div>
							@endforeach
						</div>
					 
					</div>
				</div>
			</div>
		</div> --}}
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
	<script type="text/javascript">
		var min_ask = {{$product_ask->ask}};
		var max_ask = 0;
		 
				$('.place_ask_input').keyup(function(){
					var ask = $(this).val();	
					var percentage = $('.paypal_fee_dynamic').val();
					if(percentage > 0){
						var a = (percentage/100)*ask;
						$('.paypal_fee_dynamic_cal').html('£ '+a.toFixed(3));
						var total = ask-a;
						if($('.term_check').prop('checked')){
							$('.place_ask_button').removeAttr('disabled');
						}else{
							$('.place_ask_button').prop('disabled', true); 
						}
						$('.total_hi').val(total);
						$('.total_ask_dynamic_cal').html('£ '+total);
					}else{
			          	if($('.term_check').prop('checked')){
							$('.place_ask_button').removeAttr('disabled');
						}else{
							$('.place_ask_button').prop('disabled', true); 
						}
						$('.total_hi').val(total);
						$('.total_ask_dynamic_cal').html('£ '+ask);
					}

					
					if(ask == ''){
						$('.total_hi').val('');
						$('.place_ask_button').prop('disabled', true); 
						$('.place-a-bid-current-highest').removeClass('lowest_one'); 
						$('.place-a-bid-current-highest').removeClass('lowest_ask'); 
						$('.ask_t_p').html(`<div class="col text-white text-center">
									<p class="mb-0 d-inline">Lowest Ask:</p>
									<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic">£ `+min_ask+` </p>
								</div>`);
					}else{
						if(ask > max_ask){
							$('.place-a-bid-current-highest').removeClass('lowest_one'); 
							$('.place-a-bid-current-highest').removeClass('lowest_ask'); 
							
							$('.ask_t_p').html(`<div class="col text-white text-center">
									<p class="mb-0 d-inline">You have the Greatest Ask at:</p>
									<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic">£ `+ask+` </p>
								</div>`);
						}
						if(ask < min_ask){
							$('.place-a-bid-current-highest').addClass('lowest_ask');
							$('.place-a-bid-current-highest').removeClass('lowest_one'); 

							$('.ask_t_p').html(`<div class="col text-white text-center">
										<p class="mb-0 d-inline">You have the Lowest Ask at:</p>
										<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic">£ `+ask+` </p>
									</div>`);
						}
						if(ask > min_ask && ask < max_ask){
							$('.place-a-bid-current-highest').addClass('lowest_ask');
							$('.place-a-bid-current-highest').removeClass('lowest_one'); 

							$('.ask_t_p').html(`<div class="col text-white text-center">
										<p class="mb-0 d-inline">Your Ask is:</p>
										<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic">£ `+ask+` </p>
									</div>`);
						}
						if(ask == min_ask){
							$('.place-a-bid-current-highest').removeClass('lowest_ask'); 
							$('.place-a-bid-current-highest').addClass('lowest_one');
							$('.ask_t_p').html(`<div class="col text-white text-center">
										<p class="mb-0 d-inline">You have one of the Lowest Ask at:</p>
										<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic">£ `+ask+` </p>
									</div>`);
						}
					}
					
				});
				$('.term_check').click(function(){

		          	if($('.term_check').prop('checked') && $('total_hi').val() != '' && $('.is_exist_already').val() != ''){
						$('.place_ask_button').removeAttr('disabled');
		          	}else{
		          		$('.place_ask_button').prop('disabled', true); 
		          	}
				})
			 
	</script>
@endsection