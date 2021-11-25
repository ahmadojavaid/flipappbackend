@extends('admin.layout.index')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                    	<a href="{{route('admin.dashboard')}}">
                    		Dasboard
                    	</a>
                    </li>
                    <li class="breadcrumb-item active">Shipment</li>
                </ol>
            </div>
            <h4 class="page-title">Shipment Fee Setting</h4>
        </div>
    </div>
</div>
<div class="card col-lg-4">
    <div class="card-body">
		<form method="post" action="{{route('admin.setting.save_shipment')}}" id="form_sub" >
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
				@include('flash::message')
			@csrf
			<div class="row">
	            <div class="col-lg-12">
	                <div class="form-group">
	                    <label for="exampleInputPassword1">Title</label>
			            <input type="text" value="{{$shipment->title}}" id="product_name" required="" name="title" class="form-control">
	                </div>
	        	</div>
	            <div class="col-lg-12">
	                <div class="form-group">
	                    <label for="exampleInputPassword1">Shipment Fee</label>
			            <input type="number" value="{{$shipment->value}}" id="product_name" required="" name="shipment_fee" class="form-control">
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
@section('script')
	<script type="text/javascript">
		$(document).ready(function(){
			 
		});
	</script>
@endsection
