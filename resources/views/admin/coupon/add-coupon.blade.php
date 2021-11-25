@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('add-coupon') }}

<div class="card">
    <div class="card-body">
<form method="post" action="{{route('admin.coupon.store')}}" id="form_sub"  enctype="multipart/form-data">
	
		
	     
	        
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

		                    
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Name</label>
			                        <input type="text" value="{{old('name')}}" id="product_name"required =""  name="name" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Code</label>
			                        <input type="text" id="product_name" value="{{old('code')}}" required ="" name="code" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Maximum Uses</label>
			                        <input type="number" id="product_name" value="{{old('max_uses')}}" required =""  name="max_uses" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Discount Amount</label>
			                        <input type="number" id="product_name" required ="" value="{{old('discount_amount')}}" name="discount_amount" class="form-control">
			                    </div>
		                	</div>
		                	<div class="col-lg-6">
			                    <div class="form-group">
			                        <label for="exampleInputPassword1">Start At - Expires At</label>
			                        <input type="text" id="starts_at" required ="" value="{{old('starts_at')}}"  name="starts_at" class="form-control">
			                    </div>
		                	</div>
		                	 
	                	</div>

	                	 
			<div class="m-t-20">
			<button type="submit" id="submit-all" class="btn btn-primary waves-effect waves-light">Submit</button>
			</div>
</form>
 




			 


 





</div> <!-- end card-body-->
	        </div> <!-- end card-->
<!-- container -->
@endsection 
	@include('admin.js-css-blades.datepicker')

@section('script')
	  <script type="text/javascript">
	 	$(document).ready(function(){
	 		$('#starts_at').daterangepicker({
	 			minDate: moment(),
	 			 
	 			locale: {
			      format: 'YYYY/MM/DD'
			    }
	 		});
	 	

	 	});
	 </script>
@endsection
