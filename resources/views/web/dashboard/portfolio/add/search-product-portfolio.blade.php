@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
         
         <div class="modal-dialog modal-follow-width shadow" role="document">
			<div class="modal-content rounded-0 border-0">
				 
				<div class="" id="searchProduct" style="background-color: white;">
					<div class="input-group ">
						<input type="text" class="form-control border-right-0 rounded-0 shadow-none " style="border: 1px #E9E9E9 solid;" placeholder="SEARCH FOR PRODUCT"
							  aria-label="SEARCH FOR PRODUCT"
							  aria-describedby="basic-addon3" id="search_product">
						<div class="input-group-append">
							<span class="input-group-text index-search-btn  " style="border: 1px #E9E9E9 solid;" id="basic-addon3"><i class="fas fa-search"></i></span>
						</div>
					</div>

				</div>
				<div class="modal-body rounded-0 border-0 bg-white" id="allproducts">
					<div class="html">
						
						<hr style="">
					</div>
					<div class="row ">
	                    <div class="spinner_center">
	                        <div class="spinner-grow spinner-grow-large spinner_f hide" role="status">
	                          <span class="sr-only">Loading...</span>
	                        </div>
	                    </div>
                	</div>
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
@section('jsfooter')
	 <script>
	 	$('#search_product').keyup(function(e){
	 		var search = $(this).val();
	 		if(e.keyCode == 13) {
             	$('.spinner_f').removeClass('hide');
				searchh(search);
			}
	 		
	 	});
	 	function searchh(search){
	 		$.ajax({
                url     : "{{ route('seller.portfolio.get_products') }}?search="+search,
                method  : 'get',
                dataType: "json",
                success : function(response){
                	$('.spinner_f').addClass('hide');
                	console.log(response.status);
                    if(response.status == 1){
                    	var html = '';
                    	$.each(response.products, function( index, value ) {
						  html += `<a href="{{route('seller.portfolio.add')}}?id=`+value.id+`">
						  				<div class="d-flex flex-row " style="cursor: pointer;">
											<div class=" p-2 d-flex flex-column justify-content-center">
												<img src="{{asset('')}}`+value.product_image.image_url+`"
													style="width: 60px;height: 60px;object-fit: cover;">
											</div>
											<div class=" p-2 d-flex flex-column justify-content-center">
												<p class="mb-0 font-weight-bold">`+value.product_name+`</p>
											</div>

										</div>
									</a>`;
						});
                        $('.html').html(html);
                    }
                    if(response.status == 0){
                    	var h = `<p>
									No Record Found...
								</p>`;
						$('.html').html(h);
                    }
                },
                error: function (reject) {
		            if( reject.status === 422 ) {
		            	$('.spinner_f').addClass('hide');
		            	$('.html').html('');
		            }
            	}
            });
	 	}
	 </script>
@endsection