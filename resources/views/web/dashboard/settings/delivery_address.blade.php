@extends('layouts.dashboard.master')
@section('title', 'Profile')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
		<div class="container">
			<div class="row pt-3 ">
				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					<h3 class="font-weight-bold">DELIVERY ADDRESS</h3>
				</div>
				<div class="col-sm-12 col-md-2">

				</div>
			</div>
			<div class="row pt-3 ">
				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					 @if (count($errors) > 0)
	                    <div class="alert alert-danger">
	                        <strong>Whoops!</strong> There were some problems with your input.
	                        <ul>
	                            @foreach ($errors->all() as $error)
	                                <li>{{ $error }}</li>
	                            @endforeach
	                        </ul>
	                    </div>
	                @endif
				</div>
				<div class="col-sm-12 col-md-2">

				</div>
			</div>
			<div class="row p-5">
				<div class="col-sm-12 col-md-2">

				</div>
				<div class="col-sm-12 col-md-8 text-center">
					<form method="post" action="{{route('seller.profile.delivery_address')}}">
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
						{{-- <div class="form-group">
							<input type="text" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none"  placeholder="City" name="city">
						</div> --}}
						<div class="form-group">
							<input type="hidden" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none url_se"   placeholder="Zip" name="url">
						</div>
						{{-- <div class="form-group">
							<input type="text" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none"  placeholder="State" name="state">
						</div> --}}
						{{-- <div class="form-group">
							<input type="text" required="" class="form-control border-top-0 border-right-0 border-left-0 shadow-none"  placeholder="Postal Code" name="postal_code">
						</div> --}}
						<button type="submit" class="btn btn-dark rounded-0 border-0 mt-4 mb-5" style="width: 10rem;">SAVE</button>
					</form>
				</div>
				<div class="col-sm-12 col-md-2">

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
@endsection
@section('jsfooter')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMLj2D4bFeoGuuVDV1H-Zn4b6FG5C0z1s&libraries=places&language=en"></script>
	<script type="text/javascript">
		
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
        	// Swal.fire('Any fool can use a computer')
        	// Swal.fire({
         //    title: 'Are you sure?',
         //    text: '',
         //    type: 'warning',
         //    showCancelButton: !0,
         //    confirmButtonText: 'Yes, delete it!',
         //    cancelButtonText: 'No, cancel!',
         //    confirmButtonClass: 'btn btn-success mt-2',
         //    cancelButtonClass: 'btn btn-danger ml-2 mt-2',
         //    buttonsStyling: !1
         //  	})
            // swal("" , "Please enter correct address with street number" , "warning");
            // $("#Paddress").val("");
            // return false;
        }
        $("#zip").val(zip);
        // $("#city_user").val(city_user);
  //       $("#city").val(city_user);
  //       $("#a_account_address_city").val(city_user);
  //       $("#state_user").val(state);
  //       $("#a_account_address_state").val(state);
  //       $("#zip").val(zip);
  //       $("#a_account_address_postal_code").val(zip);
  //                   $("#account_address").val($("#Paddress").val());
  //           $("#account_address_street").val(account_address_street);
  //           $("#account_address_city").val(city_user);
  //           $("#account_address_suberb").val(city_user);
  //           $("#account_address_state").val(state);
  //           $("#account_address_postal_code").val(zip);
  //       	    $('#latitude').val(place.geometry.location.lat());
		// $('#longitude').val(place.geometry.location.lng());

  //       var address_user = $("#Paddress").val();
  //       $("#a_account_address").val(address_user);
    });

         
	// $("#Paddress").bind("paste", function(e){
	//         swal("" , "Please enter correct address with street number" , "warning");
	//         $("#Paddress").val("");
	//         $("#latitude").val("");
	//         return false;
	// } );

	// $("#Paddress").on("keyup", function(e){
	//         $("#latitude").val("");
	// });

	</script>
@endsection