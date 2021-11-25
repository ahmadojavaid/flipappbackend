@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('edit-coupon',$coupon->id) }}

<div class="card">
    <div class="card-body">
<form method="post" action="{{route('admin.coupon.update')}}" id="form_sub"  enctype="multipart/form-data">
	
		
	     
	        
	                <h4 class="mb-3 header-title"></h4>
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
	                
	                    @csrf
	                    <div class="alert alert-danger  hide error_msgs" role="alert">
                                          
                                        </div>
                                       <div class="alert alert-success hide success_msgs" role="alert">
                                           
                                        </div>
	                    <div class="row">
	                    	<input type="hidden" name="coupon_id" value="{{$coupon->id}}">
		                    
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Name</label>
			                        <input type="text" value="{{$coupon->name}}" id="product_name"required =""  name="name" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Code</label>
			                        <input type="text" id="product_name" value="{{$coupon->code}}" required ="" name="code" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Maximum Uses</label>
			                        <input type="number" id="product_name" value="{{$coupon->max_uses}}" required =""  name="max_uses" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Discount Amount</label>
			                        <input type="number" id="product_name" required ="" value="{{$coupon->discount_amount}}" name="discount_amount" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Start At - Expires At</label>
			                        <input type="text" id="start_at" required ="" value="{{date('m/d/Y',strtotime($coupon->starts_at))}}"  name="starts_at"  class="form-control">
			                    </div>
		                	</div>
		                	{{-- <div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Expires At</label>
			                        <input type="date" id="expires_at" value="{{date('m/d/Y',strtotime($coupon->expires_at))}}"  required ="" name="starts_at"   class="form-control">
			                    </div>
		                	</div> --}}
	                	</div>

	                	 
			<div class="m-t-20">
			<button type="submit" id="submit-all" class="btn btn-primary waves-effect waves-light">Submit</button>
			</div>
</form>
<!-- <div class="row dropzone">
    <div id="myAwesomeDropzone" class="col-lg-12" >
        <div class="fallback">
            <input type="file" name="file[]" multiple="" class="display-none" />
        </div>
        <div class="dz-message needsclick">
            <i class="h1 text-muted dripicons-cloud-upload"></i>
            <h3>Drop files here or click to upload.</h3>
        </div>
	</div>
	 
</div> -->




			 


 





</div> <!-- end card-body-->
	        </div> <!-- end card-->
<!-- container -->

@endsection 
	

@section('script')

@parent
	 <script type="text/javascript">
	 	$(document).ready(function(){
	 		$('#start_at').daterangepicker({
	 			minDate: moment(),
	 			startDate: '{{$coupon->starts_at}}',
    			endDate: '{{$coupon->expires_at}}',
	 			locale: {
			      format: 'YYYY/MM/DD'
			    }
	 		});
	 	

	 	});
	 </script>
@endsection
@include('admin.js-css-blades.datepicker')