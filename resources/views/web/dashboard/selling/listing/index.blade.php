@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
    	<nav>
            <div class="nav nav-tabs border-0 text-center" id="nav-tab" role="tablist">
                <a class="nav-item nav-link sell-pending-nav-link active m-2 selling_p_l" style="width: 10rem;" id="nav-home-tab"
                   data-toggle="tab" href="#nav-home" role="tab"
                   aria-controls="nav-home" aria-selected="true">SELLING</a>
                <a class="nav-item nav-link m-2 sell-pending-nav-link selling_p_l_h" style="width: 10rem;" id="nav-profile-tab"
                   data-toggle="tab" href="#nav-home" role="tab"
                   aria-controls="nav-profile" aria-selected="false">HISTORY</a>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
        	<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
				<div class="row pt-3">
					<div class="col">
						
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
									<th scope="col" style="font-weight: 500;background-color: #000000;border: 1px white solid;width: 10rem;">Product Status</th>
									<th scope="col" style="font-weight: 500;background-color: #000000;border: 1px white solid;width: 10rem;">Payment Status</th>
									<th scope="col" style="font-weight: 500;background-color: #000000;border: 1px white solid;width: 10rem;">Amount</th>
									<th scope="col" style="font-weight: 500;background-color: #000000;border: 1px white solid;width: 10rem;">Action</th>
									
								</tr>
								</thead>
								<tbody class="text-center" style="background-color: #F8F8F8;">
									
								</tbody>
							</table>
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
				ajax: "{{route('seller.selling.get_sale_products')}}",
			    "aaSorting": [],
				columns: [
				    {data: 'product.product_name',name:'product.product_name',searchable:false,orderable:false},
					{data: 'product_status',name:'product_status',searchable:false,orderable:false},
					{data: 'payment_status',name:'payment_status' ,searchable:false,orderable:false},
					{data: 'total_amount',name:'total_amount' ,searchable:false,orderable:false},
					{data: 'action',name:'action' ,searchable:false,orderable:false},	
				]
			});
			$('#DataTables_Table_0_filter').hide();
			$('.selling_p_l').click(function(){
		    	datatbl.ajax.url('{{ route("seller.selling.get_sale_products") }}').draw();
		    });
		    $('.selling_p_l_h').click(function(){
		    	datatbl.ajax.url('{{ route("seller.selling.get_sale_products_history") }}').draw(); 
	    	})
			$(document).on('click','.deliver_p',function(){
				// Swal.fire({
				//   title: 'Are you sure?',
				//   text: "Product Deliver",
				//   icon: 'warning',
				//   showCancelButton: true,
				//   confirmButtonColor: '#3085d6',
				//   cancelButtonColor: '#d33',
				//   confirmButtonText: 'Yes'
				// }).then((result) => {
				//   if (result.value) {
				   	window.location = $(this).data('href');
				//   }
				// })
			});
			
		});
 

	    
	    
    	 
	 	 
	 	 
	</script>
@endsection