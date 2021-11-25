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
										   style="width: 5rem;border: 2px white solid;padding: 3px !important;">SIZE
									</button>
								</div>
							</div>
							<form method="post" action="{{route('seller.ask.ask_save')}}">
								@csrf
								<input type="hidden" value="" name="ff" class="is_exist_already">
								<input type="hidden" name="product_id" value="{{request()->id}}">
								<div class="p-1 place-a-bid-current-highest">
									<div class="row ask_t_p hide">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Lowest Ask:</p>
											<p class="mb-0 d-inline font-weight-bold pl-2 ask_dynamic"> </p>
										</div>
									</div>
									<div class="row choose_size_first">
										<div class="col text-white text-center">
											<p class="mb-0 d-inline">Please Choose Size First.</p> 
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
													<input type="text" required="" autocomplete="off" name="ask" class="form-control-plaintext place-a-bid-amount-text-field place_ask_input" id="staticBid"
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
											<p class="mb-0 d-inline paypal_fee_dynamic_cal">£ </p>
										</div>
									</div>
									<input type="hidden" name="product_size"  class="product_size_model">
									<div>
										<hr class="m-0">
									</div>
									<div class="d-flex flex-row justify-content-between">
										<div class="p-2">
											<p class="mb-0 font-weight-bold">Total:</p>
										</div>
										<div class="p-2">
											<input type="hidden" name="total" class="total_hi">
											<p class="mb-0 font-weight-bold total_ask_dynamic_cal ">£0 </p>
										</div>
									</div>

								</section>
								<div class="row pt-3 pb-2">
									<div class="col">
										<div class="d-flex flex-row justify-content-center place-a-bid-font-size ">
											<div class="p-2 ">
												<p class="mb-0 font-weight-bold pr-2">ASK EXPIRES IN:</p>
											</div>
											<div class="p-2 place-a-bid-expire shadow">
												  <select name="expiry_day" required="">
												  	@for($i=1; $i<60; $i++)
												  		<option value="{{$i}}">{{$i}}</option>
												  	@endfor
												  </select>
												  {{-- <input type="number" name="expiry_date" required=""> --}}
											</div>
											<div class="p-2 ">
												Days<i class="far fa-clock pl-1"></i>
											</div>
										</div>
									</div>
								</div>
								@if(empty(Auth::user()->paymentCreditCard) && empty(Auth::user()->paymentPaypal))
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
										<button disabled="" type="submit" class="btn p-2 rounded-0 text-white bg-dark shadow-none place_ask_button" style="width: 10rem;border: 2px white solid;">PLACE ASK
										</button>
									</div>
								</div>
							</form>

						</section>
					
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
    </div>
    
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
	      		@if(empty(Auth::user()->paymentCreditCard) && empty(Auth::user()->paymentPaypal))
	      			<p style="color:red">Please Add one payment method for placing a ask.</p>
	      		@endif
		        <a href="{{(Auth::user()->paymentPaypal) ? 'javascript:;' : route('seller.paypal.verification')}}?return_url={{url()->current()}}"  title="{{(Auth::user()->paymentPaypal) ? 'Paypal Account is already Added' : ''}}" style="background-color: #000000; color: white" class="btn">
		        	PAYPAL
		        	@if(Auth::user()->paymentPaypal)
		        		<i style="color: greenyellow;" class="fas fa-check"></i>
		        	@endif
		        </a>
		        <br>
		        <a id="btn-credit" title="{{(Auth::user()->paymentCreditCard) ? 'Credit card already added' : ''}}"  data-toggle="pill" href="{{ (Auth::user()->paymentCreditCard) ? 'javascript:;' : '#credit_card_div'}}" role="tab" aria-controls="pills-profile" aria-selected="false" style="background-color: #000000; color: white" class="btn">
		        	CREDIT CARD 
		        	@if(Auth::user()->paymentCreditCard)
		        		<i style="color: greenyellow;" class="fas fa-check"></i>
		        	@endif
		        </a> 
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

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@include('admin.js-css-blades.sweetalert')
@include('admin.js-css-blades.flat-datepicker') 
@section('cssheader')
	<link rel="stylesheet" href="{{asset('css/mobirise-icons.css')}}">
	<link rel="stylesheet" href="{{asset('css/mbr-additional.css')}}" type="text/css">
@endsection
@section('jsfooter')
@parent
<script src="{{asset('js/credit/jquery.payform.min.js')}}"></script>
<script src="{{asset('js/credit/script.js')}}"></script>
	<script type="text/javascript">
		var min_ask = 0;
		var max_ask = 0;
		$('.btn_model_size').click(function(){
				$('.place_ask_input').val('');
				$('.place_ask_button').prop('disabled', true); 
				$('.choose_size_first').addClass('hide');
				$('.ask_t_p').removeClass('hide');
				$('.total_ask_dynamic_cal').html('£ -');
				$('.paypal_fee_dynamic_cal').html('£ -');
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
		          url: "{{route('get_lowest_ask_size')}}",
		          data:data,
		          dataType: "JSON",
		          success: function (response) { 
			          if(response.status == 1){
			          	if(response.min_ask > 0){
			          		min_ask = response.min_ask;
			          		max_ask = response.max_ask; 
			          		$('.ask_dynamic').html('£ '+response.min_ask);
			          	}else{
			          		min_ask = 0;
			          		max_ask = 0;
			          		$('.ask_dynamic').html('£ - (Not Anyone added a Ask');
			          	}
			          	if(response.is_exist == 1){
			          		$('.is_exist_already').val('');
			          		$('.already_ask').removeClass('hide');
			          	}else{
			          		$('.already_ask').addClass('hide');

			          		$('.is_exist_already').val('4');

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
			});

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