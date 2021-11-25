@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('product-bid-ask',request()->size_id) }}
	 

	<div class="row">
        <div class="col-12">
        	@include('flash::message')
            <!-- <div class="card-box"> -->
                <div class="row">
                    <div class="col-lg-8">
                         
                    </div>
                    <div class="col-lg-4">
                        {{-- <div class="text-lg-right mt-3 mt-lg-0"> 
                            <a href="{{route('admin.product.create')}}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add Product</a>
                        </div> --}}
                    </div><!-- end col-->
                </div> <!-- end row -->
            <!-- </div> end card-box -->
        </div> <!-- end col-->
    </div>

    
    <div class="col-xl-12">
        <div class="card-box">
            <h4 class="header-title mb-4">Product Ask & Bids (By Size).</h4>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#home" data-toggle="tab" aria-expanded="false" id="asks_get" class="nav-link active">
                        Asks
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#profile" data-toggle="tab" aria-expanded="true" id="bids_get" class="nav-link ">
                        Bids
                    </a>
                </li>
                 
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="home">
                    <div class="row m-t-20">
						<div class="col-lg-12">
					        <div class="card-box">
					            <h4 class="header-title"></h4>
					            <p class="sub-header">
					                
					            </p>

					            <div class="table-responsive ">
					                <table class="table datatables table-hover mb-0">
					                    <thead>
					                    <tr>
					                    	<th>User</th>
					                        <th>Ask</th>
					                        <th>Bid</th>
					                        <th>Transaction Fee</th>
					                        <th>Coupon </th>
					                        <th>Total</th>
					                        <th>Expire Date</th>
					                        <th>Status</th>
					                    </tr>
					                    </thead>
					                    <tbody>
					                    </tbody>
					                </table>
					            </div> <!-- end table-responsive-->

					        </div> <!-- end card-box -->
					    </div>
					</div>
                </div>
            </div>
        </div> <!-- end card-box-->
    </div>

	@include('admin.js-css-blades.datatables')
@endsection

@section('script')
@parent
<script type="text/javascript">
	$(document).ready(function(){
	 
		var datatbl = $('.datatables').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('admin.bids_asks.get_asks',request()->size_id) }}",
		    "aaSorting": [],
			columns: [
			    {data: 'user.first_name',name:'user.first_name'},
				{data: 'ask',name:'ask',},
				{data: 'bid',name:'bid',},
				{data: 'transaction_fee',name:'transaction_fee'},
				{data: 'coupon',name:'coupon',"orderable": false,"searchable": false},
			    {data: 'total',name:'total'},
			    {data: 'expires_at',name:'expires_at'},
			    {data: 'status',"orderable": false,"searchable": false},
			]
		});
	    datatbl.column(2).visible(false);
	    datatbl.column(4).visible(false);
	    $('#bids_get').click(function(){
	    	datatbl.column(2).visible(true);
	    	datatbl.column(1).visible(false);
	    	datatbl.column(4).visible(true);
	    	datatbl.ajax.url('{{ route('admin.bids_asks.get_bids',request()->size_id) }}').draw();
	    });
	     $('#asks_get').click(function(){
	    	datatbl.column(1).visible(true);
	    	datatbl.column(2).visible(false);
	    	datatbl.column(4).visible(false);
	    	datatbl.ajax.url('{{ route('admin.bids_asks.get_asks',request()->size_id) }}').draw();
	    })
	});
	 
</script>
@endsection