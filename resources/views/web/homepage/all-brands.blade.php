@extends('layouts.homepage.master')
@section('title', 'Brands')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">
        <section style="background-color: #F6F6F6;" class="mt-5 mb-5 pt-2 pb-2 pr-5 pl-5">
        	<div class="row">
        		<h2>All Brands</h2>
        	</div>
            <div class="row pt-5 pb-5 accordion" id="accordionExample">
            	 
            	@foreach($brands as $brand)
	                <div class="col-sm-12 col-md-4 p-2 float_left">
	                    <div class="card text-white border-0 shadow rounded-0 blog-card-height">
	                        <img src="{{ asset($brand->brand_image) }}" class="card-img img-fluid brand_all_page_img" alt="...">
	                        <div class="card-img-overlay p-0">
	                            <div class=" p-2 border-0 blog-card-header">
	                            </div>
	                        </div>
	                        
		                        <div class="card  shadow border-0 m-2">
		                            <div class="card-header bg-white" id="headingFive">
		                                <h2 class="mb-0">


		                                    <button class="btn btn-link faq-collapse-btn " id="btn_colpse" type="button" data-toggle="collapse" data-target="#collapseFive{{$brand->id}}"
		                                            aria-expanded="false" aria-controls="collapseFive{{$brand->id}}">
		                                        <div class="d-flex flex-row justify-content-between">
		                                            <div>
		                                                <p class="mb-0 text-left" style="padding-right: 42px;">{{$brand->brand_name}}</p>
		                                            </div>
		                                            <div>
		                                                <i class="fas fa-chevron-right pull-right"></i>
		                                                <i class="fas fa-chevron-down pull-right"></i>
		                                            </div>
		                                        </div>


		                                    </button>


		                                </h2>
		                            </div>
	                        	</div>
		                        <div id="collapseFive{{$brand->id}}" class="collapse shadow m-2 all-collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
		                            <div class="card-body pt-0" style="text-align: initial; color:black">
		                                {{$brand->description}}
		                            </div>
		                        </div>
	                    	 
	                    </div>
	                </div>
                @endforeach
            	
            </div>
            <div class="row">
	  	<div class="col-md-12">
	  		<div class="pull-right"> 
	  			{{$brands->render()}}
	  		</div>
	  	</div>
	  </div>
        </section>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
	<script type="text/javascript">
		$(document).ready(function(){
			// $('.faq-collapse-btn').click(function(){
			// 	$('#btn_colpse').attr('class','btn btn-link faq-collapse-btn collapsed');
			// 	$(this).attr('class','btn btn-link faq-collapse-btn');
			// 	$('.all-collapse').hide();
			// 	$(this).parent().parent().parent().next('.all-collapse').show();
			// })
		});
	</script>
@endsection