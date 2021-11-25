@extends('layouts.dashboard.master')
@section('title', 'Bid')
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
										   style="width: 5rem;border: 2px white solid;padding: 3px !important;">{{strtoupper($product_bid->productSize->productTypeSize->name)}}
									</button>
								</div>
							</div>
							<form method="post" action="{{route('seller.bid.update')}}">
								@csrf
								
								<input type="hidden" value="" name="ff" class="is_exist_already">
								<input type="hidden" name="product_id" value="{{$product_bid->product_id}}">
								<input type="hidden" name="bid_id" value="{{$product_bid->id}}">
								<div class="p-1 place-a-bid-current-highest">
									<div class="row bid_t_p">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Highest Bid:</p>
											<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic"> {{$product_bid->getHighestBid($product_bid->product_id,$product_bid->product_size_id)}} </p>
										</div>
									</div>
									 
									
								</div>

								<div class="row pt-3 pb-1 ">
									<div class="col "> 
											<div class="form-group row">
												<div class="col-sm-2">

												</div>
												<label for="staticBid" class="col-sm-3 col-form-label">Bid Amount:</label>
												<div class="col-sm-5">
													<input type="text" value="{{$product_bid->bid}}" required="" autocomplete="off" name="bid" class="form-control-plaintext place-a-bid-amount-text-field place_bid_input" id="staticBid"
														  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
												</div>
												<div class="col-sm-2">

												</div>
											</div> 
									</div>
								</div>
								<section class="p-2 place-a-bid-font-size" style="background-color: #F3F3F3;">
									
									{{-- <div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>PayPal Protection ({{@$setting->value}}%)</p>
											<input type="hidden" name="paypal_fee_dynamic" value="{{@$setting->value}}" class="paypal_fee_dynamic">
										</div>
										<input type="hidden" class="paypal_fee_dynamic_calulate" value="{{$product_bid->transaction_fee}}" name="percentage_amount">
										<div class="p-2">
											<p class="mb-0 d-inline">+</p>
											<p class="mb-0 d-inline paypal_fee_dynamic_cal">£ {{$product_bid->transaction_fee}}</p>
										</div>
									</div> --}}
									<input type="hidden" name="product_size" value="{{$product_bid->product_size_id}}"  class="product_size_model">
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>Discount</p>
										</div>
										<div class="p-2">
											<p class="mb-0 d-inline plus_coupon">-</p>
											@if($product_bid->couponBid)
												<b class="mb-0 d-inline coupon_amount_html" style="cursor: pointer;" data-toggle="modal" data-target="#exampdddleModalCenter" id="">{{$product_bid->couponBid->coupon->discount_amount}}</b>
												<input type="hidden" name="amount" value="{{$product_bid->couponBid->coupon->discount_amount}}" class="coupon_amount_input">
												<input type="hidden" name="coupon_code" value="{{$product_bid->couponBid->coupon->code}}" class="coupon_code_input">
											@else
												<b class="mb-0 d-inline coupon_amount_html" style="cursor: pointer;" data-toggle="modal" data-target="#exampdddleModalCenter" id="">Add Discount </b>	
												<input type="hidden" name="amount" class="coupon_amount_input">
												<input type="hidden" name="coupon_code" class="coupon_code_input">			
											@endif
											
										</div>
									</div> 

									<div>
										<hr class="m-0">
									</div>
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p class="mb-0 font-weight-bold">Total you will pay:</p>
										</div>
										<div class="p-2">
											<input type="hidden" name="total" value="{{$product_bid->total}}" class="total_hi">
											<p class="mb-0 font-weight-bold total_bid_dynamic_cal ">{{$product_bid->total}} </p>
										</div>
									</div>

								</section>
								<div class="row pt-3 pb-2">
									<div class="col">
										<div class="d-flex flex-row justify-content-center place-a-bid-font-size ">
											<div class="p-2 ">
												<p class="mb-0 font-weight-bold pr-2">BID EXPIRES IN:</p>
											</div>
											<div class="p-2 place-a-bid-expire shadow"> 
												 	{{-- {{dd(dateDiffInDays($product_bid->expires_at))}} --}}
												   <select name="expiry_day" required="">
													  	@for($i=1; $i<$difference; $i++)
													  	{{-- <option  value="{{$i}}">{{$i}}</option> --}}
														  	@if($i == 1)

														  		<option {{(dateDiffInDays($product_bid->expires_at) == 'today' && dateDiffInDays($product_bid->expires_at) > 0 ) ? 'selected' : ''}} value="today">Today</option>
														  	@else
														  		<option {{(dateDiffInDays($product_bid->expires_at) == $i && dateDiffInDays($product_bid->expires_at) > 0 ) ? 'selected' : ''}} value="{{($i-1)}}">{{($i-1)}}</option>
														  	@endif
													  	@endfor
												  </select>
											</div>
											<div class="p-2 ">
												Days<i class="far fa-clock pl-1"></i> 
											</div>
										</div>
										@if(dateDiffInDays($product_bid->expires_at) == 0 && dateDiffInDays($product_bid->expires_at) != 'today')
										  		<div class="d-flex flex-row justify-content-center place-a-bid-font-size  p-2 badge bg-soft-danger text-danger mb-3 shadow-none m-r-5">Expire. Please Choose days</div>
											@endif	
									</div>
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
										<button  type="submit" class="btn p-2 rounded-0 text-white bg-dark shadow-none  " style="width: 10rem;border: 2px white solid;">PLACE BID
										</button>
									</div>
								</div>
							</form>

						</section>
					
				</div>
			</div>
		</div>
		<!-- Modal -->
		


	<!-- Modal -->
	<div class="modal fade border-0" id="exampdddleModalCenter" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-bidS-Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header" STYLE="background-color: #000000;">
					<h5 class="modal-title text-white" id="exampleModalCenterTitle">Coupon Code</h5>
					<button type="button " class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<input type="text" name="coupon" placeholder="Coupon Code" class="form-control coupon_input" />
							</div>
							<div class="msg_er"></div>
						</div>
						<div class="col-lg-12">
							<div class="form-group float_right">
								<button id="ajax-alert" class="btn btn-danger ">Apply</button>
							</div>
						</div>
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
@parent
@endsection
@include('admin.js-css-blades.sweetalert')
@section('jsfooter')
@parent
	<script type="text/javascript">
		var min_bid = {{$product_bid->getLowestBid($product_bid->product_id,$product_bid->product_size_id)}};
		var max_bid = {{$product_bid->getHighestBid($product_bid->product_id,$product_bid->product_size_id)}};
		@if($product_bid->couponBid)
			var dis_amount = {{$product_bid->couponBid->coupon->discount_amount}};
		@else
			var dis_amount = 0;
		@endif
		
		$('.place_bid_input').keyup(function(){
			var bid = $(this).val();	
			var percentage = $('.paypal_fee_dynamic').val();
			if(percentage > 0){
				var a = (percentage/100)*bid;
				$('.paypal_fee_dynamic_calulate').val(a);
				$('.paypal_fee_dynamic_cal').html('£ '+a.toFixed(3));
				var coupon = $('.coupon_amount_input').val();
				var total = Number(bid)+Number(a)-Number(coupon);
				
				if(total > 0){
					$('.total_hi').val(total);
					$('.total_bid_dynamic_cal').html('£ '+total);	
				}else{
					$('.total_hi').val(0);
					$('.total_bid_dynamic_cal').html('£ 0');
				}
				
			}else{
	          	
				$('.total_hi').val(total);
				$('.total_bid_dynamic_cal').html('£ '+bid);
			}

			
			if(bid == ''){
				$('.total_hi').val('');
				$('.place_bid_button').prop('disabled', true); 
				$('.place-a-bid-current-highest').removeClass('lowest_one'); 
				$('.place-a-bid-current-highest').removeClass('lowest_bid'); 
				$('.bid_t_p').html(`<div class="col text-white text-center">
							<p class="mb-0 d-inline">Highest bid:</p>
							<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic">£ `+max_bid+` </p>
						</div>`);
			}else{
				if(bid > max_bid){
					$('.place-a-bid-current-highest').removeClass('lowest_one'); 
					$('.place-a-bid-current-highest').removeClass('lowest_bid'); 
					
					$('.bid_t_p').html(`<div class="col text-white text-center">
							<p class="mb-0 d-inline">You have the Highest bid at:</p>
							<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic">£ `+bid+` </p>
						</div>`);
				}
				if(bid < min_bid){
					$('.place-a-bid-current-highest').addClass('lowest_bid');
					$('.place-a-bid-current-highest').removeClass('lowest_one'); 

					$('.bid_t_p').html(`<div class="col text-white text-center">
								<p class="mb-0 d-inline">You have the Lowest bid at:</p>
								<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic">£ `+bid+` </p>
							</div>`);
				}
				if(bid > min_bid && bid < max_bid){
					$('.place-a-bid-current-highest').addClass('lowest_bid');
					$('.place-a-bid-current-highest').removeClass('lowest_one'); 

					$('.bid_t_p').html(`<div class="col text-white text-center">
								<p class="mb-0 d-inline">Your bid is:</p>
								<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic">£ `+bid+` </p>
							</div>`);
				}
				if(bid == min_bid){
					$('.place-a-bid-current-highest').removeClass('lowest_bid'); 
					$('.place-a-bid-current-highest').addClass('lowest_one');
					$('.bid_t_p').html(`<div class="col text-white text-center">
								<p class="mb-0 d-inline">You have one of the Lowest bid at:</p>
								<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic">£ `+bid+` </p>
							</div>`);
				}
			}
			
		});
			 
		$('#ajax-alert').click(function(){
			var v = $('.coupon_input').val();
			if(v != ''){
				$('.msg_er').html('');

				$.ajax({
		          type: "POST",
		          url: "{{route('seller.bid.code_verification')}}",
		          data:{'code' : v},
		          dataType: "JSON",
		          success: function (response) { 
			           if(response.status == 1){
			           		dis_amount = response.amount;
			           		$('.coupon_amount_input').val(dis_amount);
			           		$('.coupon_code_input').val(response.code);
			           		$('.coupon_amount_html').html("£ "+dis_amount); 
			           		var plce_bid = $('.place_bid_input').val();
			           		var total = Number(plce_bid) - Number(dis_amount) + Number($('.paypal_fee_dynamic_calulate').val());
			           		if(total < 0){
			           			$('.total_bid_dynamic_cal').html('£  0');
			           			$('.total_hi').val(0);
			           		}else{
			           			$('.total_bid_dynamic_cal').html("£ "+total);
			           			$('.total_hi').val(total);
			           		}
			           		
			           		$('.plus_coupon').html('-');
			           		$('#exampdddleModalCenter').modal('hide');
			           }
		          },
		          error: function(jqXHR, exception){
					if (jqXHR.status == 422) {
			              var html_error  ='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>'+jqXHR.responseJSON.message+'</div></div>';
			              $('.msg_er').html(html_error); 
		        	}
		          }
		      	});
			}else{
				 var html_error ='<div class="pgn push-on-sidebar-open pgn-simple"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>Coupon field is required.</div></div>';
				 $('.msg_er').html(html_error);
			}
		})
				 
	</script>
@endsection