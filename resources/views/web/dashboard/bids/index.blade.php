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
										   style="width: 5rem;border: 2px white solid;padding: 3px !important;">SIZE
									</button>
								</div>
							</div>
							<form method="post" action="{{route('seller.bid.bid_save')}}">
								@csrf
								<input type="hidden" value="" name="ff" class="is_exist_already">
								<input type="hidden" name="product_id" value="{{request()->id}}">
								<div class="p-1 place-a-bid-current-highest">
									<div class="row bid_t_p hide">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Highest Bid:</p>
											<p class="mb-0 d-inline font-weight-bold pl-2 bid_dynamic"> </p>
										</div>
									</div>
									<div class="row choose_size_first"  >
										<div class="col text-white text-center" >
											<p class="mb-0 d-inline " style="color: red; font-weight: bold;">Please Choose Size First.</p> 
										</div>
									</div>
									<div class="row already_bid hide">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Sorry! You can't place a bid, Because you have already place a bid.</p> 
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
													<input type="text" required="" autocomplete="off" name="bid" class="form-control-plaintext place-a-bid-amount-text-field place_bid_input" id="staticBid"
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
										<input type="hidden" class="paypal_fee_dynamic_calulate" name="percentage_amount">
										<div class="p-2">
											<p class="mb-0 d-inline">+</p>
											<p class="mb-0 d-inline paypal_fee_dynamic_cal">£ </p>
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
											<p class="mb-0 font-weight-bold total_bid_dynamic_cal "> </p>
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
												   <select name="expiry_day" required="" class="expiry_day">
													  	{{-- @for($i=1; $i<=60; $i++)
													  		<option value="{{$i}}">{{$i}}</option>
													  	@endfor --}}
												  </select>
											</div>

											<div class="p-2 ">
												<i class="far fa-clock pl-1"></i>
											</div>
										</div>
									</div>
								</div>
								@if(!Auth::user()->paymentCreditCard)
									<div class="row p-2">
										<div class="col  ">
											<ul style="margin-left: 0; padding-left: 0; cursor: pointer" data-toggle="modal" data-target="#exampleModalCenterPayment" >
												<li class="d-flex justify-content-between align-center" 
												style="border-top: 1px dotted;;
														border-bottom: 1px dotted;;
														padding: 10px 15px;">
													 
												    <div>
												    	<img style="display: inline-block; width: 18px;" src="//stockx-assets.imgix.net/svg/icons/credit_card.svg?auto=compress,format" alt="credit card">
												    	<p style="display: inline-block; margin-left: 15px; margin-bottom: 0">Please add a payment method.</p>
												    </div>
												    <div>
												    	<img style="width: 18px;" src="//stockx-assets.imgix.net/svg/icons/pencil.svg?auto=compress,format" alt="pencil">
												    </div>
												</li>
											</ul>
										</div>
									</div>
								@endif


								<div class="row p-2">
									<div class="col text-center">
										<div class="custom-control custom-checkbox mr-sm-2">
											<input type="checkbox" class="custom-control-input term_check" name="term_condition" id="customControlAutosizing">
											<label class="custom-control-label mb-0 place-a-bid-font-size" for="customControlAutosizing">I AGREE TO THE TERMS AND CONDITIONS</label>
										</div>

									</div>
								</div>
								<div class="row">
									<div class="col text-center">
										<button disabled="" type="submit" class="btn p-2 rounded-0 text-white bg-dark shadow-none place_bid_button" style="width: 10rem;border: 2px white solid;">PLACE BID
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
							@if($product)
								@if($product->ProductSizes)
									@foreach($product->ProductSizes as $product_size)  
										<div class="col-sm-12 col-md-6 p-2">
											<button class="btn shadow border-0 btn_model_size single-item-btn-modal p-3 btn-block {{($product_size->productAskBySize) ? 'oo' : 'hide'}} " data-product_id = "{{@$product->id}}" data-size_id = "{{@$product_size->id}}" data-size="{{@$product_size->productTypeSize->name}}" data-id = "{{@$product_size->productTypeSize->id}}" data-dismiss="modal">
												<p class="mb-0 font-weight-bold h4" >{{@$product_size->productTypeSize->name}}</p>
												{{-- <p class="mb-0" >£295</p> --}}
											</button>
											<input type="hidden" name="product_size"  class="product_size_model">
										</div>
									@endforeach
								@endif
							@endif
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
	@if(!Auth::user()->paymentCreditCard)
		<div class="modal fade" id="exampleModalCenterPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header" style="background-color: #000000; color: white">
		        <h5 class="modal-title" id="exampleModalLongTitle">Add Payment</h5>
		        <button type="button" class="close" style="color: white" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="text-center">
			        <a   href="{{ (Auth::user()->paymentPaypal) ? 'javascript:;' : route('seller.paypal.verification')}}?return_url={{url()->current()}}" title="{{(Auth::user()->paymentPaypal) ? 'Paypal account is already added' : ''}}" style="background-color: #000000; color: white" class="btn">
			        	PAYPAL
			        	@if(Auth::user()->paymentPaypal)
			        		<i style="color: greenyellow;" class="fas fa-check"></i>
			        	@endif
			        </a>
			        <br>
			        <a id="btn-credit"  title="{{(Auth::user()->paymentCreditCard) ? 'Credit card already added' : ''}}"  data-toggle="pill" href="{{(Auth::user()->paymentCreditCard) ? 'javascript:;' : '#credit_card_div'}}" role="tab" aria-controls="pills-profile" aria-selected="false" style="background-color: #000000; color: white" class="btn">
			        	CREDIT CARD 
			        	@if(Auth::user()->paymentCreditCard)
			        		<i style="color: greenyellow;" class="fas fa-check"></i>
			        	@endif
			        </a><p style="color:red">(credit card manadatory for place a bid)</p>
		      	</div>
		      	<div class="tab-pane fade  " id="credit_card_div" style="display: none" role="tabpanel" aria-labelledby="pills-contact-tab">
					<div class="col-md-12">
					<div class="card border-0 rounded-0 shadow p-5" id="payment-form">

						<div class="creditCardForm">
				            <div class="heading">
				                <h1>Add Credit Card</h1>
				            </div>
				            <div class="payment">
				                <form method="post" action="{{route('seller.credit.verification')}}" name="demo-form" id="fomr_s" >
				                	@csrf
				                    <div class="form-group field owner">
				                        <label for="owner">Owner</label>
				                        <input type="text" required=""  name="owner" class="form-control" id="owner">
				                    </div>
				                    <div class="form-group field CVV">
				                        <label for="cvv">CVV</label>
				                        <input type="text" required="" name="cvv" class="form-control" id="cvv">
				                    </div>
				                    <div class="form-group field" id="card-number-field">
				                        <label for="cardNumber">Card Number</label>
				                        <input type="text" required="" name="card" class="form-control" id="cardNumber">
				                    </div>
				                    <div class="form-group field" id="expiration-date">
				                        <label>Expiration Date</label>
	            							<input type="date" id="publish_date" name="exp_m" class="form-control">
				                        

				                    </div>
				                    <div class="form-group" id="credit_cards">
				                        <img src="{{asset('assets/img/credit/visa.jpg')}}" id="visa">
				                        <img src="{{asset('assets/img/credit/mastercard.jpg')}}" id="mastercard">
				                        <img src="{{asset('assets/img/credit/amex.jpg')}}" id="amex">
				                    </div>
				                    <div class="form-group text-right" id="pay-now">
				                        <button type="submit" class="btn btn-primary " id="confirm-purchase">Confirm</button>
				                    </div>
				                </form>
				            </div>
				        </div>
						    	{{-- <form action="/checkout" id="hosted-fields-form" method="post">
							  <label for="card-number">Card Number</label>
							  <div id="card-number"></div>

							  <label for="cvv">CVV</label>
							  <div id="cvv"></div>

							  <label for="expiration-date">Expiration Date</label>
							  <div id="expiration-date"></div>

							  <div id="checkout-message"></div>

							  <input type="submit" value="Pay" disabled />
							</form>  --}} 
					</div>
					</div>
				</div>
		      </div>
		      <div class="modal-footer">
		      </div>
		    </div>
		  </div>
		</div>
	@endif

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <!-- Modal -->
   
 
@endsection
@section('cssheader')
	<link rel="stylesheet" href="{{asset('css/mobirise-icons.css')}}">
	<link rel="stylesheet" href="{{asset('css/mbr-additional.css')}}" type="text/css">
@parent
@endsection
@include('admin.js-css-blades.sweetalert')
@include('admin.js-css-blades.flat-datepicker') 
@section('jsfooter')
@parent 
<script src="{{asset('js/credit/jquery.payform.min.js')}}"></script>
<script src="{{asset('js/credit/script.js')}}"></script>
	<script type="text/javascript">
		var min_bid = 0;
		var max_bid = 0;

		var dis_amount = 0;
		$('.btn_model_size').click(function(){
				$('.place_bid_input').val('');
				$('.coupon_amount_html').html('Add Discount');
				$('.coupon_amount_input').val('');
				$('.paypal_fee_dynamic_calulate').val(0);
				$('.paypal_fee_dynamic_cal').html('£ -');
				$('.choose_size_first').addClass('hide');
				$('.total_bid_dynamic_cal').html('£ 0');
				$('.bid_t_p').removeClass('hide');
				var id = $(this).data('id');
				var size = $(this).data('size');
				var size_id = $(this).data('size_id');
				var product_id = $(this).data('product_id');
				$('.product_size_model').val(size_id);
				$('.btn_size_body').html('SIZE ('+size.toUpperCase()+')');
				var data = { 
							size_id : size_id, 
							product_id : product_id 
						};
				$.ajax({
		          type: "POST",
		          url: "{{route('get_highest_bid_size')}}",
		          data:data,
		          dataType: "JSON",
		          success: function (response) { 
			          if(response.status == 1){
			          	if(response.min_bid > 0){
			          		min_bid = response.min_bid;
			          		max_bid = response.max_bid; 
			          		$('.bid_dynamic').html('£ '+response.min_bid);
			          	}else{
			          		min_bid = 0;
			          		max_bid = 0;
			          		$('.bid_dynamic').html('£ - (Not Anyone added a bid)');
			          	}
			          	if(response.is_exist == 1){
			          		$('.is_exist_already').val('');
			          		$('.already_bid').removeClass('hide');
			          	}else{
			          		$('.already_bid').addClass('hide');
			          		$('.is_exist_already').val('4');
			          	}

						$('.place_bid_button').prop('disabled', true);
						var a = '';
						if(response.difference > 0)
						{
							for(var i = 1; i<= response.difference; i++){
								if(i == 1){
									a += `<option value="today">Today</option>`;
								}else{
									a += `<option value="`+(i-1)+`">`+(i-1)+`</option>`;
								}
							} 
							$('.expiry_day').html(a);
						}else{
							$('.place-a-bid-expire').html("Sorry You can't place a bid because after few hour Asks is Expire");
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
				$('.place_bid_input').keyup(function(){
					var bid = $(this).val();	
					var percentage = $('.paypal_fee_dynamic').val();
					if(percentage > 0){
						var a = (percentage/100)*bid;
						$('.paypal_fee_dynamic_calulate').val(a);
						$('.paypal_fee_dynamic_cal').html('£ '+a.toFixed(3));
						var coupon = $('.coupon_amount_input').val();
						var total = Number(bid)+Number(a)-Number(coupon);
						if($('.term_check').prop('checked')){
							$('.place_bid_button').removeAttr('disabled');
						}else{
							$('.place_bid_button').prop('disabled', true); 
						}
						if(total > 0){
							$('.total_hi').val(total);
							$('.total_bid_dynamic_cal').html('£ '+total);	
						}else{
							$('.total_hi').val(0);
							$('.total_bid_dynamic_cal').html('£ 0');
						}
						
					}else{
			          	if($('.term_check').prop('checked') && $('.is_exist_already').val() != ''){
							$('.place_bid_button').removeAttr('disabled');
						}else{
							$('.place_bid_button').prop('disabled', true); 
						}
						$('.total_hi').val(total);
						$('.total_bid_dynamic_cal').html('£ '+bid);
					}

					
					if(bid == ''){
						$('.total_hi').val('');
						$('.place_bid_button').prop('disabled', true); 
						$('.place-a-bid-current-highest').removeClass('lowest_one'); 
						$('.place-a-bid-current-highest').removeClass('lowest_bid'); 
						$('.bid_t_p').html(`<div class="col text-white text-center">
									<p class="mb-0 d-inline">Lowest bid:</p>
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
				$('.term_check').click(function(){

		          	if($('.term_check').prop('checked') && $('total_hi').val() != '' && $('.is_exist_already').val() != ''){
						$('.place_bid_button').removeAttr('disabled');
		          	}else{
		          		$('.place_bid_button').prop('disabled', true); 
		          	}
				});


			});
		$("#exampdddleModalCenter").on('shown.bs.modal', function (e) {
			var a = $(".place_bid_input").val();
			if(a.length <=0){
				$(this).modal('hide');
				Swal.fire('Please Enter amount of Bid firstly');
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
			           		var total = Number(plce_bid) - Number(dis_amount);
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

		 $('#btn-credit').click(function(){
	    	 
	    	$('#credit_card_div').toggle();
	    });
		$('#publish_date').flatpickr({
			minDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
			defaultDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
			dateFormat: "Y/m/d"
		});
		 

		 
				 
	</script>
@endsection