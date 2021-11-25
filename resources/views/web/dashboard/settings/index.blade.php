@extends('layouts.dashboard.master')
@section('title', 'Profile')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
		<div class="container">
			<div class="row">
				<div class="col">
					@include('flash::message')
					<ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
						<li class="nav-item m-2" style="width: 14rem;">
							<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
							   aria-selected="true">
								<p class="mb-1 h6 font-weight-bold">DELIVERY ADDRESS</p>
								<p class="mb-0">YOUR DELIVERY ADDRESS</p>
							</a>
						</li>
						<li class="nav-item m-2" style="width: 14rem;">
							<a class="nav-link rounded-0" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
							   aria-controls="pills-profile" aria-selected="false">
								<p class="mb-1 h6 font-weight-bold">PAYMENT</p>
								<p class="mb-0">PAYMENT METHOD</p>
							</a>
						</li>
						{{-- <li class="nav-item m-2" style="width: 14rem;">
							<a class="nav-link rounded-0" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
							   aria-controls="pills-contact" aria-selected="false">
								<p class="mb-1 h6 font-weight-bold">OFFER</p>
								<p class="mb-0">SELECT COUNTRY</p>
							</a>
						</li> --}}
						{{-- <li class="nav-item m-2" style="width: 14rem;">
							<a class="nav-link rounded-0" id="pills-shippingTo-tab" data-toggle="pill" href="#pills-shippingTo" role="tab"
							   aria-controls="pills-shippingTo" aria-selected="false">
								<p class="mb-1 h6 font-weight-bold">SHIPPING TO</p>
								<p class="mb-0">SELECT COUNTRY</p>
							</a>
						</li> --}}
					</ul>
					<div class="tab-content m-3" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="card shadow border-0 rounded-0">
								<div class="card-body">
									<div class="row">
										<div class="col text-right">
											<a href="{{route('seller.setting.delivery_address')}}">
												<img src="{{asset('assets/img/icons/pencil-edit-button%20(1).png')}}">
											</a>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="form-row">
												<div class="form-group col-md-6">
													<label class="delivery-address-form-label">First Name</label>
													<input type="text" readonly class="shadow-none form-control delivery-address-form-input"
														  value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->first_name : ''}}">
												</div>
												<div class="form-group col-md-6">
													<label class="delivery-address-form-label">Country</label>
													<input type="text" readonly class="shadow-none form-control delivery-address-form-input"
														  value="United Kingdom">
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label class="delivery-address-form-label">Last Name</label>
													<input type="text" readonly class="shadow-none form-control delivery-address-form-input" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->last_name : ''}}">
												</div>
												<div class="form-group col-md-6">
													<label class="delivery-address-form-label">Postal Code</label>
													<input type="text" readonly class="shadow-none form-control delivery-address-form-input" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->postal_code : ''}}">
												</div> 
											</div>
											<div class="form-group">
												<label for="inputAddress" class="delivery-address-form-label">Address</label>
												<textarea class="shadow-none form-control delivery-address-form-input" readonly="" 
												>{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->address : ''}}</textarea>
											</div>
											 

										 
												
												<div class="form-group">
													<label class="delivery-address-form-label">Location URL (Google Map).</label>
													<a href="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->location_url : 'javascript:void(0)'}}" target="blank" class="shadow-none form-control delivery-address-form-input" style="overflow: hidden;"  > {{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->location_url : ''}}</a>
												 
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							<div class="card shadow border-0 rounded-0">
								<div class="card-header text-white" style="background-color: #000000;">
									<p class="mb-0 ">PAYMENT METHOD</p>
								</div>
								<div class="card-body">
									@foreach($payment_methods as $key => $payment)
										<div class="d-flex flex-row justify-content-between">
											<div>
												<img src="{{asset('assets/'.$payment->icon)}}" class="img-fluid">
											</div>
											<div class="d-flex flex-column justify-content-center	payment_badge">


												{!!(paymentStatus(Auth::user()->id,$payment->key)) ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Unverified</span>' !!} 
												
											</div>
											<div class="d-flex flex-column justify-content-center">
												@if(paymentStatus(Auth::user()->id,$payment->key)) 
												{{-- <a href='{{route("seller.paypal.verification")}}' class="btn btn-primary btn-sm">Verified </a> --}}
												@else
													@if($payment->key == 'paypal')
													<a href='{{route("seller.paypal.verification")}}' class="btn btn-primary btn-sm">Verified </a>
													@else
														<a id="btn-credit" data-toggle="pill" href="#credit_card_div" role="tab" aria-controls="pills-profile" aria-selected="false" class="btn btn-primary btn-sm">Add Credit Card <span style="">(mandatory)</span> </a>
													@endif
												@endif
											</div>
										</div>
										<hr>
									 @endforeach

									 <div class="tab-pane fade  " id="credit_card_div" style="display: none" role="tabpanel" aria-labelledby="pills-contact-tab">
										<div class="card border-0 rounded-0 shadow" id="payment-form">

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
									                    <div class="form-group" id="pay-now">
									                        <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
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
						</div>
						{{-- <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
							<div class="card border-0 rounded-0 shadow">
								<div class="card-body text-center">
									<p class="font-weight-bold h5 mb-0">WHICH COUNTRY'S OFFER
										YOU WANT TO SEE?</p>
								</div>
								<div class="card-header text-white" style="background-color: #000000;">
									<p class="mb-0" style="font-size: 18px;">SELECT COUNTRY</p>
								</div>
								<div class="card-body">
									@foreach($countries as $key => $country)
										<div class="d-flex flex-row justify-content-between">
											<div>
												<img src="{{asset('assets/img/icons/Mask Group 49.png')}}" class="img-fluid d-inline">
												<p class="font-weight-bold pl-2 d-inline pl-2">{{ucfirst($country->name)}}</p>
											</div>
											<div class="d-flex flex-column justify-content-center">
												<div class="custom-control custom-radio">
													<input type="radio" checked="" id="customRadio3" name="customRadioffer" class="custom-control-input shadow-none">
													<label class="custom-control-label" for="customRadio3"></label>
												</div>
											</div>
										</div>
									@endforeach
									 
								</div>
							</div>
						</div> --}}
						{{-- <div class="tab-pane fade" id="pills-shippingTo" role="tabpanel" aria-labelledby="pills-shippingTo-tab">
							<div class="card border-0 rounded-0 shadow">
								<div class="card-body text-center">
									<p class="font-weight-bold h5 mb-0">WHICH COUNTRIES YOU ARE
										WILLING TO SHIP TO?</p>
								</div>
								<div class="card-header text-white" style="background-color: #000000;">
									<p class="mb-0" style="font-size: 18px;">SELECT COUNTRY</p>
								</div>
								<div class="card-body">
									@foreach($countries as $key => $country)
										<div class="d-flex flex-row justify-content-between">
											<div>
												<img src="{{asset('assets/img/icons/Mask Group 49.png')}}" class="img-fluid d-inline">
												<p class="font-weight-bold pl-2 d-inline pl-2">{{ucfirst($country->name)}}</p>
											</div>

											<div class="d-flex flex-column justify-content-center">

												<div class="custom-control custom-radio">
													<input type="radio" checked="" id="customRadio6" name="customRadioShip" class="custom-control-input shadow-none">
													<label class="custom-control-label" for="customRadio6"></label>
												</div>


											</div>
										</div>
									@endforeach
									 <a class="font-weight-bold d-inline bg-white text-decoration-none" style="color: #AFAFAF;" data-toggle="collapse"
									   href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">SHIPPING PRICE</a> 
									<div class="collapse" id="collapseExample">
										<div class="card card-body border-0 rounded-0" style="background-color: #F6F6F6;">
											<div class="input-group ">
												<div class="input-group-prepend">
													<span class="input-group-text delivery-span-currency-ship" id="basic-addon1">£</span>
												</div>
												<input type="text" class="form-control shadow-none"
													  style="font-size: 25px;max-width: 10rem;min-width: 10rem;">
												<button class="btn shadow rounded-0 text-white border-0 text-center p-1"
													   style="width: 8rem;background-color: #2F2F2F;margin: 6px 6px 6px 37px;">SAVE
												</button>
											</div>
										</div>
									</div>
									<hr>
									
								</div>
							</div>
						</div> --}}
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
	@include('admin.js-css-blades.flat-datepicker') 

@section('cssheader')
<link rel="stylesheet" type="text/css" href="{{asset('css/credit/styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/credit/demo.css')}}">
@endsection
@section('jsfooter')
<script src="{{asset('js/credit/jquery.payform.min.js')}}"></script>
<script src="{{asset('js/credit/script.js')}}"></script>

{{-- <script src="https://js.braintreegateway.com/web/3.44.2/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.44.2/js/hosted-fields.min.js"></script> --}}
    {{-- <script type="text/javascript">
        var form = document.querySelector('#hosted-fields-form');
  		var submit = document.querySelector('input[type="submit"]');
  		var nounce = '';
		braintree.client.create({
		authorization: 'sandbox_24qgfdxh_x5t6dqfrj4p376qm'
		}, function (clientErr, clientInstance) {
		if (clientErr) {
		  console.error(clientErr);
		  return;
		}
		braintree.hostedFields.create({
		  client: clientInstance,
		  styles: {
		    'input': {
		      'font-size': '14px'
		    },
		    'input.invalid': {
		      'color': 'red'
		    },
		    'input.valid': {
		      'color': 'green'
		    }
		  },
		  fields: {
		    number: {
		      selector: '#card-number',
		      placeholder: '4111 1111 1111 1111'
		    },
		    cvv: {
		      selector: '#cvv',
		      placeholder: '123'
		    },
		    expirationDate: {
		      selector: '#expiration-date',
		      placeholder: '10/2019'
		    }
		  }
		}, function (hostedFieldsErr, instance) {
		  if (hostedFieldsErr) {
		    console.error(hostedFieldsErr);
		    return;
		  }
		  submit.removeAttribute('disabled');
		  form.addEventListener('submit', function (event) {
		    event.preventDefault();
		    instance.tokenize(function (tokenizeErr, payload) {
		      if (tokenizeErr) {
		        // console.error(tokenizeErr);
		        // return;
		      }
		      nounce = payload.nonce;


		      // instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
		        $.ajax({
		          type: 'POST',
		          url: '{{route("seller.credit.verification")}}',
		          data: {'paymentMethodNonce': nounce}
		        }).done(function(result) {
		          // Tear down the Hosted Fields form
		          instance.teardown(function (teardownErr) {
		            if (teardownErr) {
		              console.error('Could not tear down the Hosted Fields form!');
		            } else {
		              console.info('Hosted Fields form has been torn down!');
		              // Remove the 'Submit payment' button
		              $('#hosted-fields-form').remove();
		            }
		          });

		          if (result.success) {
		            $('#checkout-message').html('<h1>Success</h1><p>Your Hosted Fields form is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>');
		          } else {
		            $('#checkout-message').html('<h1>Error</h1><p>Check your console.</p>');
		          }
		        });
		      // });
		    });
		  }, false);
		});
		});
    </script> --}}
    <script type="text/javascript">
    	$('#publish_date').flatpickr({
				minDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
				defaultDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
				dateFormat: "Y/m/d"
			});
	    function openNav() {
	        document.getElementById("mySidenav").style.width = "100%";
	    }
	    function closeNav() {
	        document.getElementById("mySidenav").style.width = "0";
	    }
	    $('#btn-credit').click(function(){
	    	 
	    	$('#credit_card_div').toggle();
	    })
	</script>
@endsection