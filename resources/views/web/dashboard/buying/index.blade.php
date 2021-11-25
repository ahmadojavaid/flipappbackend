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
									<button class="btn p-2 rounded-0 text-white bg-dark shadow-none btn_size_body" data-toggle="modal" data-target="#"
										   style="width: 5rem;border: 2px white solid;padding: 3px !important;">
										   {{($product_ask->productSize) ? ucfirst($product_ask->productSize->productTypeSize->name) : ''}}
									</button>
								</div>
							</div>
							<form method="post" action="{{route('seller.buy.payment_process')}}">
								@csrf
								<input type="hidden" value="" name="ff" class="is_exist_already">
								<input type="hidden" name="product_id" value="{{$product->id}}">
								<div class="p-1 place-a-bid-current-highest">
									{{-- <div class="row bid_t_p hide">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Highest Bid:</p>
											<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic"> </p>
										</div>
									</div> --}}
									<div class="row choose_size_first"  >
										<div class="col text-white text-center" >
											<p class="mb-0 d-inline " style=" font-weight: bold;">Current Lowest Ask: £ {{$product_ask->min_ask}}</p> 
										</div>
									</div>
									<div class="row already_bid hide">
										<div class="col text-white text-center">
											 
										</div>
									</div>
								</div>

								<div class="row pt-3 pb-1 ">
									<div class="col "> 
											<div class="form-group row">
												<div class="col-sm-2">

												</div>
												<label for="staticBid" class="col-sm-3 col-form-label">BUYING AT:</label>
												<div class="col-sm-5">
													<input type="text" required="" autocomplete="off" name="bid" style="background: #969696; color: white;" value="{{$product_ask->min_ask}}" readonly="" class="form-control-plaintext place-a-bid-amount-text-field place_bid_input" id="staticBid"
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
										<input type="hidden" class="paypal_fee_dynamic_calulate" value="{{$transaction_fee}}" name="percentage_amount">
										<div class="p-2">
											<p class="mb-0 d-inline">+</p>
											<p class="mb-0 d-inline paypal_fee_dynamic_cal">£ {{$transaction_fee}}</p>
										</div>
									</div> --}}
									<input type="hidden" name="product_size"  class="product_size_model">
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p>Discount</p>
										</div>
										<div class="p-2">
											<p class="mb-0 d-inline plus_coupon">+</p>
											<b class="mb-0 d-inline coupon_amount_html" style="cursor: pointer;" data-toggle="modal" data-target="#exampdddleModalCenter" id="">Add Discount </b>
											<input type="hidden" name="amount" class="coupon_amount_input">
											<input type="hidden" name="coupon_code" class="coupon_code_input">
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
											<input type="hidden" name="total" class="total_hi">
											<p class="mb-0 font-weight-bold total_bid_dynamic_cal ">£ {{(float)$product_ask->min_ask + (float)$transaction_fee}} </p>
										</div>
									</div>

								</section>
								<div class="row pt-3 pb-2">
									<div class="col">
										@if(Auth::user()->verifiedPaymentMethod)
										 
											@foreach(Auth::user()->verifiedPaymentMethod as $key => $payment)
												<div class="col-md-4 image-checkbox text-center" style="float:left">
											        <label class="" >
											            <img src="{{asset('assets/'.$payment->paymentMethod->icon)}}" class="img-fluid img_payment" />
											            <input type="checkbox" name="payment_by" value="{{$payment->paymentMethod->key}}" />
											        </label>
											    </div>
									    	@endforeach
									    @endif
									</div>
								</div>
								<div class="row p-2">
									<div class="col text-center">
										<div class="custom-control custom-checkbox mr-sm-2">
											<input type="checkbox" required="" class="custom-control-input term_check" name="term_condition" id="customControlAutosizing">
											<label class="custom-control-label mb-0 place-a-bid-font-size" for="customControlAutosizing">I AGREE TO THE TERMS AND CONDITIONS</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col text-center">
										<button type="submit" class="btn p-2 rounded-0 text-white bg-dark shadow-none place_bid_button" style="width: 10rem;border: 2px white solid;">Buy Now
										</button>
									</div>
								</div>
							</form>

						</section>
					
				</div>
			</div>
		</div>
		<!-- Modal -->
			<div class="modal fade border-0" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="VIEW-ALL-bidS-Title" aria-hidden="true">
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
	<style type="text/css">
	.image-checkbox{
        cursor: pointer;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        border: 2px solid transparent;
        outline: 0;
        width: 200px;
		height: 100px;
    }

    .image-checkbox input[type="checkbox"]{
        display: none;
    }
    .image-checkbox-checked{
        border-color: #969696;
    }
	</style>
@parent
@endsection
@include('admin.js-css-blades.sweetalert')
@section('jsfooter')
@parent
	<script type="text/javascript">
		var min_bid = 0;
		var max_bid = 0;
		var dis_amount = 0;
		 
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

		 

        // sync the state to the input
        $(".image-checkbox").on("click", function (e) {
        	$(".image-checkbox").find('input[type="checkbox"]').removeAttr("checked");
        	$(".image-checkbox").removeClass("image-checkbox-checked");
            if ($(this).hasClass('image-checkbox-checked')) {
                $(this).removeClass('image-checkbox-checked');
                $(this).find('input[type="checkbox"]').removeAttr("checked");
            }
            else {
                $(this).addClass('image-checkbox-checked');
                $(this).find('input[type="checkbox"]').attr("checked", "checked");
            }
            e.preventDefault();
        });
				 
	</script>
@endsection