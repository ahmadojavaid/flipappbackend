@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
		<div class="row">
			<div class="col">
				<p class="mb-0 following-follow-text">FOLLOWING</p>
			</div>
		</div>
		<div class="row pt-3">
			<div class="col">
				<button onclick="addProduct()" class="btn p-2 rounded-0 border-0 shadow font-weight-bold"
					   style="width: 12rem;background-color: #EFEFEF;font-size: 12px;"
					   data-toggle="modal" data-target="#followModal">
					ADD PRODUCT <img class="pl-3" src="{{asset('assets/img/icons/Group 649.png')}}">
				</button>
			</div>
		</div>
		<div class="row pt-4">
			<div class="col">
				@include('flash::message')
				<div class="table-responsive ">
					<table class="table datatables">
						<thead class="text-center text-white">
						<tr>
							<th scope="col" style="font-weight: 500;background-color: #000000; width: 15rem;border: 1px white solid;">Item</th>
							<th scope="col" style="font-weight: 500;background-color: #000000;border: 1px white solid;width: 10rem;">Market Value</th>
							<th scope="col" style="font-weight: 500;background-color: #000000;border: 1px white solid;width: 10rem;">Lowest Ask</th>
							
						</tr>
						</thead>
						<tbody class="text-center" style="background-color: #F8F8F8;">
							{{-- <tr>
								<td>
									<div class="d-flex flex-row justify-content-start">
										<div class="p-1">
											<img src="./img/products/Screenshot%202019-07-13%20at%2016.16.24.png"
												style="width: 60px;height: 60px;object-fit: cover;">
										</div>
										<div class="p-1">
											<div class="d-flex flex-column justify-content-between">
												<div>
													<p class="mb-0 font-weight-bold">SUPREME®/CHAMPION®<br>
														CHROME S/S TOP BLACK</p>
												</div>
												<div class="d-flex flex-row justify-content-between">
													<div>
														<p class="mb-0 d-inline">Size:</p>
														<p class="mb-0 d-inline font-weight-bold pl-2">L</p>
													</div>
													<div>
														<a class="text-decoration-none" href="#" style="color: #EA2126">Remove <i
															   class="fas fa-trash-alt pl-1"></i></a>
													</div>

												</div>

											</div>
										</div>
									</div>
								</td>
								<td class="font-weight-bold">£237</td>
								<td class="font-weight-bold">£237</td>
							</tr> --}}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    
    <!-- Modal -->
	<div class="modal fade" id="followModal" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
		<div class="modal-dialog modal-follow-width shadow" role="document">
			<div class="modal-content rounded-0 border-0">
				<div class="modal-header rounded-0" style="background-color: #2F2F2F;">
					<h1 class="modal-title text-white " id="followModalTitle">PROXX</h1>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-header rounded-0 pr-5 pl-5" style="background-color: #C4C4C4;">
					<h4 class="modal-title text-white font-weight-bold">FOLLOW</h4>

				</div>
				<div class="modal-header rounded-0 border-0 pt-4 pb-4 pr-5 pl-5" id="searchProduct" style="background-color: white;">
					<div class="input-group ">
						<input type="text" class="form-control border-right-0 rounded-0 shadow-none " style="border: 1px #E9E9E9 solid;" placeholder="SEARCH FOR PRODUCT"
							  aria-label="SEARCH FOR BRAND"
							  aria-describedby="basic-addon3" id="search_product" >
						<div class="input-group-append">
							<span class="input-group-text index-search-btn  " style="border: 1px #E9E9E9 solid;" id="basic-addon3"><i class="fas fa-search"></i></span>
						</div>
					</div>

				</div>
				<div class="modal-body text-center rounded-0  pr-5 pl-5 border-0 bg-white html" id="allproducts">
					
					
				</div>
				<div class="row ">
	                    <div class="spinner_center">
	                        <div class="spinner-grow spinner-grow-large spinner_f hide" role="status">
	                          <span class="sr-only">Loading...</span>
	                        </div>
	                    </div>
                	</div>

				<div class="modal-body text-center rounded-0  pr-5 pl-5 border-0 bg-white" id="myproductDetailmodal">
					<form method="post" action="{{route('seller.following.save')}}">
						@csrf
						<div class="d-flex flex-column justify-content-between">
							<div class="p-2">
								<img src="" style="width: 11rem;height: 10rem;object-fit: cover;" class="p_img">
							</div>
							<div class="p-2">
								<p class="mb-0 font-weight-bold h4 product_name"></p>
							</div>
							<div class="p-2 text-center">
									<select class="form-control d-inline sizes_dropdown" name="size_id" required="" style="width: 10rem;">
										 
									</select>
									<input type="hidden" name="product_id" class="product_id_c">
							</div>
							<div class="p-2">
								<button class="btn shadow rounded-0 text-white border-0 text-center p-2" style="width: 10rem;background-color: #2F2F2F;"
									   onclick="ProductDetailModalClose()">FOLLOW
								</button>
							</div>
						</div>
					</form>
				</div>

			</div>

		</div>
	</div>
	<!--	Modal end-->
@endsection
@include('admin.js-css-blades.datatables')
@include('admin.js-css-blades.sweetalert')
@section('cssheader')
@endsection
@section('jsfooter')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.datatables').css('width','100%');
			var datatbl = $('.datatables').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{route('seller.following.getFollowingProduct')}}",
			    "aaSorting": [],
				columns: [
				    {data: 'product.product_name',name:'product.product_name'},
					{data: 'productSize.retail_price',name:'productSize.retail_price',searchable:false,orderable:false},
					{data: 'lowest_ask',name:'lowest_ask' ,searchable:false,orderable:false},
					
				]
			});
			$('#DataTables_Table_0_filter').hide();

		});

		function addProduct() {
	        document.getElementById("searchProduct").style.display = "block";
	        document.getElementById("allproducts").style.display = "block";
	        document.getElementById("myproductDetailmodal").style.display = "none";
	    }

	    function searchModal(product_name,image_url,productSize) {
	    	  // console.log(productSize);
	    	 console.log(JSON.parse(JSON.stringify(productSize)));
	        
	        // console.log(productSize[0]);
	        // return false;
	        // $.each(productSize, function( index, value ) {
			  // console.log(value.id);
			// });
	    }

	    function ProductDetailModalClose() {
	        $('#followModal').modal('hide')
	    }
	    function openNav() {
	        document.getElementById("mySidenav").style.width = "100%";
	    }

	    function closeNav() {
	        document.getElementById("mySidenav").style.width = "0";
	    }
	    	$('#search_product').keyup(function(e){
	 		var search = $(this).val();
	 		if(e.keyCode == 13) {
             	$('.spinner_f').removeClass('hide');
				searchh(search);
			}
	 		
	 	});
    	$(document).on('click','#cccccc',function(){
    		document.getElementById("searchProduct").style.display = "none";
        	document.getElementById("allproducts").style.display = "none";
	        document.getElementById("myproductDetailmodal").style.display = "block";
	        $('.product_name').html($(this).data('product_name'));
	        $('.product_id_c').val($(this).data('product_id'));
	        $('.p_img').attr('src',`{{asset('')}}`+$(this).data('image_url')+``);
    		var ht = '';
    		$.each($(this).data('sizes'), function( index, value ) {
				ht += `<option value="`+value.id+`" class="font-weight-bold">
									<div class="d-flex flex-row justify-content-between">
										<div class="">
											<p class="mb-0 font-weight-bold">`+value.product_type_size.name+`</p>
										</div>
										 
									</div>
								</option>`;	  	
			});
			$('.sizes_dropdown').html(ht);
    	})
	 	function searchh(search){
	 		$.ajax({
                url     : "{{ route('seller.portfolio.get_products') }}?search="+search,
                method  : 'get',
                dataType: "json",
                success : function(response){
                	$('.spinner_f').addClass('hide');
                    if(response.status == 1){
                    	var html = '';
                    	$.each(response.products, function( index, value ) {
                    		// console.log(value.product_sizes);
                    		 a = value.product_sizes;
                    		  
						  html += `<div data-product_name = "`+value.product_name+`" data-product_id = "`+value.id+`" data-image_url = "`+value.product_image.image_url+`" data-sizes = '`+JSON.stringify(a)+`' id="cccccc">
						  				<div class="d-flex flex-row " style="cursor: pointer;">
											<div class=" p-2 d-flex flex-column justify-content-center">
												<img src="{{asset('')}}`+value.product_image.image_url+`"
													style="width: 60px;height: 60px;object-fit: cover;">
											</div>
											<div class=" p-2 d-flex flex-column justify-content-center">
												<p class="mb-0 font-weight-bold">`+value.product_name+`</p>
											</div>

										</div>
										</div>
									`;
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
	 	$(document).on('click','#remove',function(){
		 	var url = $(this).data('href');
	        Swal.fire({
	            title: 'Are you sure?',
	            text: '',
	            type: 'warning',
	            showCancelButton: !0,
	            confirmButtonText: 'Yes, delete it!',
	            cancelButtonText: 'No, cancel!',
	            confirmButtonClass: 'btn btn-success mt-2',
	            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
	            buttonsStyling: !1
	        }).then(function (t) {
	            t.value ? window.location = url  : t.dismiss === Swal.DismissReason.cancel && Swal.fire({
	              title: 'Cancelled',
	              text: 'Your Data is safe :)',
	              type: 'error'
	            })
	      	});
      });
	</script>
@endsection