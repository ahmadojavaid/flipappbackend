@extends('admin.layout.index')
@section('content')
	{{ Breadcrumbs::render('brands') }}

	<div class="row">
        <div class="col-12">
        	@include('flash::message')
            <!-- <div class="card-box"> -->
                <div class="row">
                    <div class="col-lg-8">
                         
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right mt-3 mt-lg-0"> 
                            <a href="{{route('admin.brand.add')}}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add New</a>
                        </div>
                    </div><!-- end col-->
                </div> <!-- end row -->
            <!-- </div> end card-box -->
        </div> <!-- end col-->
    </div>

	<div class="row m-t-20">
		@if(count($brands) > 0)
			@foreach($brands as $brand)
			    <div class="col-md-6 col-xl-3">
			        <div class="card-box product-box">

			            <div class="product-action">
			                <a href="{{route('admin.brand.edit',$brand->id)}}" class="btn btn-success btn-xs waves-effect waves-light"><i class="mdi mdi-pencil"></i></a>
			                <!-- <a href="javascript: void(0);" class="btn btn-danger btn-xs waves-effect waves-light"><i class="mdi mdi-close"></i></a> -->
			            </div>

			            <div>
			                <img src="{{asset($brand->brand_image)}}" alt="product-pic" class="img-fluid set_width" />
			            </div>

			            <div class="product-info">
			                <div class="row align-items-center">
			                    <div class="col text-center">
			                        <h5 class="font-16 mt-0 sp-line-1"><a href="javascript:void(0);" class="text-dark">{{$brand->brand_name}}</a> </h5>
			                    </div>
			                     
			                </div> <!-- end row -->
			            </div> <!-- end product info-->
			        </div> <!-- end card-box-->
			    </div> <!-- end col-->
		    @endforeach
	    @else
	    	<div class="col-lg-12 text-center">
                <div class="card card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text">No Record Found...</p> 
                </div>
            </div>

	    @endif
	  </div>
	  <div class="row">
	  	<div class="col-md-12">
	  		<div class="pull-right"> 
	  			{{$brands->render()}}
	  		</div>
	  	</div>
	  </div>
@endsection
