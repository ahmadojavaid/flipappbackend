@extends('layouts.homepage.master')
@section('title', 'Checkout')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
    <div class="container">
        @include('flash::message')
        <form method="post" action="{{route('seller.sell.payment_process')}}">
            @csrf
            <div class="tab-content" id="nav-tabContent">
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <h5><b>SELLING CHECKOUT </b></h5>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive mb-5">
                        <table class="table">
                            <thead class="text-center text-white">
                                <tr>
                                    <th scope="col" style="background-color: #2F2F2F; width: 15rem;border: 1px white solid;">Item</th>
                                    <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">Price</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="text-center" style="background-color: #F8F8F8;">
                                <tr>
                                    <td>
                                        <div class="d-flex flex-row justify-content-start">
                                            <div class="p-1">
                                                <img src="{{asset($product->productImage->image_url)}}" style="width: 60px;height: 60px;object-fit: cover;">
                                            </div>
                                            <div class="p-1">
                                                <div class="d-flex flex-column justify-content-between">
                                                    <div>
                                                        <p class="mb-0">{{@$product->product_name}}</p>
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="mb-0 d-inline">Size:</p>
                                                        <p class="mb-0 d-inline font-weight-bold pl-2">
                                                            {{(@$product_bid->productSize) ? ucfirst(@$product_bid->productSize->productTypeSize->name) : ''}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>£{{$product_bid->high_bid}}</td>
                                </tr>
                                <tr>
                                    <td>Payment Protection ({{$setting->value}}%)</td>
                                    <td>
                                       + £ {{$transaction_fee}}
                                        <input type="hidden" name="di_amount_input" class="di_amount_input">
                                        <input type="hidden" name="coupon_code" class="di_amount_count">
                                        <input type="hidden" name="product_id" class="product_id" value="{{$product->id}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <input type="hidden" name="place_bid_input" class="place_bid_input" value="{{$product_bid->high_bid}}">
                                    <td class="grand_total">£ {{$product_bid->high_bid + $transaction_fee }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-5">
                    <div class="card border-0 shadow rounded-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col d-flex justify-content-between">
                                    <h3>DELIVERY ADDRESS</h3>
                                    <a href="javascript:;" data-toggle="modal" data-target="#exampleModal" class="btn_edit_delivery_address">
                                        <img src="{{asset('assets/img/icons/pencil-edit-button%20(1).png')}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body"> 
        					<div class="row form_delivery_Add">
        						<div class="col">
        							<div class="form-row">
        								<div class="form-group col-md-6">
        									<label class="delivery-address-form-label">First Name</label>
        									<input type="text" readonly="" name="first_name" class="shadow-none form-control delivery-address-form-input" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->first_name : ''}}">
        								</div>
        								<div class="form-group col-md-6">
        									<label class="delivery-address-form-label">Country</label>
        									<input type="text" readonly="" class="shadow-none form-control delivery-address-form-input country_add" value="United Kingdom">
        								</div>
        							</div>
        							<div class="form-row">
        								<div class="form-group col-md-6">
        									<label class="delivery-address-form-label">Last Name</label>
        									<input type="text" readonly="" name="last_name" class="shadow-none form-control delivery-address-form-input" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->last_name : ''}}">
        								</div>
        								<div class="form-group col-md-6">
        									<label class="delivery-address-form-label">Postal Code</label>
        									<input type="text" readonly="" class="shadow-none form-control delivery-address-form-input" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->postal_code : ''}}">
        								</div> 
        							</div>
        							<div class="form-group">
        								<label for="inputAddress" class="delivery-address-form-label">Address</label>
        								<textarea class="shadow-none form-control delivery-address-form-input" readonly="">{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->address : ''}}</textarea>
        							</div>
        							 

        						 
        								
        								<div class="form-group">
        									<label class="delivery-address-form-label">Location URL (Google Map).</label>
        									<a href="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->location_url : 'javascript:void(0)'}}" target="blank" class="shadow-none form-control delivery-address-form-input" style="overflow: hidden;"> {{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->location_url : ''}}</a>
        								 
        							</div>
        						</div>
        					</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border-0 shadow rounded-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <h3>ADD PAYMENT DETAILS</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-md-6">
                                	@foreach($payment_methods as $key => $payment)
                                        <div class="card border-0 rounded-0 shadow-sm m-3">
                                            <div class="card-body d-flex justify-content-around align-items-center">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" {{($key == 0) ? 'checked' : ''}} onclick="rendertt{{$payment->key}}({{$key}})" id="emblem{{$key}}" name="payment_by" value="{{$payment->key}}" class="custom-control-input">
                                                    <label class="custom-control-label" for="emblem{{$key}}"></label>
                                                </div>
                                                <img src="{{asset('assets/'.$payment->icon)}}" class="img-fluid">

                                                {!!(paymentStatus(Auth::user()->id,$payment->key)) ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Unverified</span>' !!} 
                                            </div>
                                        </div>
                                        {{-- <div class="card border-0 rounded-0 shadow-sm m-3">
                                            <div class="card-body d-flex justify-content-around align-items-center">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="credit" name="condition" class="custom-control-input">
                                                    <label class="custom-control-label" for="credit"></label>
                                                </div>
                                                <img src="{{asset('assets/'.$payment->icon)}}" class="img-fluid">
                                            </div>
                                        </div> --}}
                                    @endforeach
                                </div>

                                <div class="col-md-6 dd_0 p_r">
                                    @if(!Auth::user()->paymentPaypal)
                                        <a href="{{route('seller.paypal.checket_verification_sell',$product->id)}}" class="btn btn-primary btn-lg">Paypal</a>
                                    @endif
                                </div>

                                <div class="col-md-6 dd_1 p_r hide">
                                    @if(!Auth::user()->paymentCreditCard)
                                    <div class="credit_card_div">
                                    </div>
                                   
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-dark rounded-0 border-0 mt-4 mb-5 btn-lg" style="width: 10rem;">Sell Product</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

    <div class="modal" tabindex="-1" id="exampleModal" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content model-lg">
          <div class="modal-header">
            <h5 class="modal-title">Shipping Address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <form method="post" action="{{route('seller.profile.delivery_address_checkout')}}">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" required="" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->first_name : ''}}"  placeholder="First Name" name="first_name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->last_name : ''}}"  placeholder="Last Name" name="last_name">
                            </div>
                            <div class="form-group">
                                <select class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="country" required="">
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{ucfirst($country->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->address : ''}}" id="Paddress"  placeholder="Address" name="address">
                            </div>
                            <div class="form-group">
                                <input type="text" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" value="{{(Auth::user()->deliveryAddress) ? Auth::user()->deliveryAddress->postal_code : ''}}" id="zip" readonly=""  placeholder="Postal Code" name="postal_code">
                            </div>
                            <div class="form-group">
                                <input type="hidden" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none url_se"   placeholder="Zip" name="url">
                            </div>
                           
                            <button type="submit" class="btn btn-secondary pull-right" style="float: right">Submit</button>
                             
                        </form>
          </div>
          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    
   
@endsection

@section('cssheader')
@endsection
@include('admin.js-css-blades.sweetalert')
@include('admin.js-css-blades.flat-datepicker')
@section('jsfooter')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMLj2D4bFeoGuuVDV1H-Zn4b6FG5C0z1s&libraries=places&language=en"></script>
<script src="{{asset('js/credit/jquery.payform.min.js')}}"></script>
<script src="{{asset('js/credit/script.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
           
            var input = document.getElementById('Paddress');
    
            var search_options = {
               //types: ['address'],
               types: ['address'],
               componentRestrictions: {country: 'uk'}
            };
            var searchBox1 = new google.maps.places.Autocomplete(input , search_options);

            searchBox1.addListener('place_changed', function() {
                var city_user = "";
                var state = "";
                var zip = "";
                var street = "";
                var account_address_street = "";
                 var place = searchBox1.getPlace();
                 $('.url_se').val(place.url);
                 var address_component = place.address_components;
                 // console.log(address_component);
                $.each(address_component, function (i, address_component) {
                    if (address_component.types[0] == "locality"){
                        city_user = address_component.long_name
                    }
                    if (address_component.types[0] == "administrative_area_level_1"){
                        state = address_component.short_name;
                    }

                    if (address_component.types[0] == "postal_code"){ 
                       zip = address_component.short_name;
                    }

                    if (address_component.types[0] == "street_number"){
                        account_address_street = address_component.long_name;
                        street = address_component.long_name;
                    }
                    if (address_component.types[0] == "route") {
                        account_address_street = account_address_street + " " + address_component.long_name;
                    }
                });

                if(street == "") { 

                    if($("#Paddress").val() != ""){
                        swal("" , "Please enter correct address with street number" , "warning");
                    }
                    $("#Paddress").val("");
                    return false;
                    
                }
                $("#zip").val(zip);
          
            });
            $(document).on('click','#Paddress',function(){
                $('.pac-container').css('z-index','99999');
            });

            $(document).on('click','.fomr_s',function(){
                // e.preventDefault();
                $('.has-spinner').buttonLoader('start');
                console.log($('.owner_c').val().length);
                if($('.owner_c').val().length <= 0 || $('.card_c').val().length <= 0 || $('.cvv_c').val().length <= 0 || $('.exp_m_c').val().length <= 0){
                    swal("" , "Credit Card All field is required" , "warning");
                    $('.has-spinner').buttonLoader('stop');
                    return false;
                }
                var formdata = new FormData();
                formdata.append('owner',$('.owner_c').val());
                formdata.append('card',$('.card_c').val());
                formdata.append('cvv',$('.cvv_c').val());
                formdata.append('exp_m',$('.exp_m_c').val());
                $.ajax({
                        type: "POST",
                        url: "{{route('seller.credit.verification_checkout')}}",
                        data: formdata,
                        processData: false,
                        contentType: false,
                        dataType: "JSON",
                        success: function (response) {
                          $('.has-spinner').buttonLoader('stop');
                          if(response.status == 1)
                          {
                            location.reload();
                          }
                          if(response.status == 2){
                            var html = '';
                            $.each(response.error_msg, function( index, value ) {
                                html += `<div class="alert alert-danger" role="alert">
                                          `+value[0]+`
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button></div>`;
                            });
                            $('.error_msg_p').html(html);
                          }
                          if(response.status == 0){
                            var html = `<div class="alert alert-danger" role="alert">
                                          `+response.err_msg+`
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button></div>`;
                            $('.error_msg_p').html(html);
                          }
                      },
                      error: function (jqXHR, exception) {
                        }
                });
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
                                $('.di_amount_input').val(dis_amount);
                                $('.btn_dis_amount').html('£ -'+dis_amount);
                                $('.di_amount_count').val(response.code);
                                // $('.coupon_amount_html').html("£ "+dis_amount); 
                                var plce_bid = $('.place_bid_input').val();
                                var total = Number(plce_bid) - Number(dis_amount);
                                if(total < 0){
                                    $('.grand_total').html('£  0');
                                    $('.grand_total').val(0);
                                }else{
                                    $('.grand_total').html("£ "+total);
                                    $('.grand_total').val(total);
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
            });
            $('.close_discount').click(function(){
                var a = $('.di_amount_input').val();
                if(a > 0){
                     var total = Number(a) + Number($('.grand_total').val());
                     $('.grand_total').html("£ "+total);
                }
                
                $('.di_amount_input').val(0);
                $('.btn_dis_amount').html('+ Add Discount');
                $('.di_amount_count').val('');
            });
        }); 
        function renderttpaypal(id){
            $('.p_r').addClass('hide');
            $('.dd_'+id).removeClass('hide');
            $('.credit_card_div').html('');
        }
        function renderttcredit_card(id){
            $('.p_r').addClass('hide');
            $('.dd_'+id).removeClass('hide');
            var html = `
                 
                    <div class="error_msg_p">

                    </div>
                    <h3 style="font-size: 22px" class="font-weight-bold mb-3">Credit Card Details</h3>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="delivery-address-form-label">Owner</label>
                            <input type="text" required="" name="owner" class="shadow-none form-control profile-change-password-input owner_c" id="owner">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="delivery-address-form-label">Card Number</label>
                            <input type="text" required="" name="card"  class="shadow-none form-control profile-change-password-input card_c" id="cardNumber">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="delivery-address-form-label">CCV</label>
                            <input type="text" required="" name="cvv" class="shadow-none form-control profile-change-password-input cvv_c" id="cvv">
                        </div>

                        <div class="form-group col-md-12">
                            <label class="delivery-address-form-label">Expiry Date</label>
                            <input type="date" required="" id="publish_date" name="exp_m" class="shadow-none form-control profile-change-password-input exp_m_c">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                             
                            <div class="form-group text-right pt-3" id="pay-now">
                                <button type="button" style="width: 10rem;background-color: #2F2F2F; color: white;"  class="has-spinner btn bg-black  fomr_s   btn-default" id="confirm-purchase">Confirm</button>
                            </div>
                        </div>
                    </div>
                 
            `;
            $('.credit_card_div').html(html);
            $('#publish_date').flatpickr({
                minDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
                defaultDate : "{{date('Y-m-d',strtotime('+1 day'))}}",
                dateFormat: "Y/m/d"
            });
        }

    </script>
@endsection