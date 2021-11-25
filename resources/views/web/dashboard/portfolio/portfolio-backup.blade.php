@extends('layouts.dashboard.master')
@section('title', 'Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="content">
        <nav>
            <div class="nav nav-tabs border-0 text-center" id="nav-tab" role="tablist">
                <a class="nav-item nav-link sell-pending-nav-link active m-2 bids_get" style="width: 10rem;" id="nav-home-tab"
                   data-toggle="tab" href="#nav-home" role="tab"
                   aria-controls="nav-home" aria-selected="true">My BIDS</a>
                <a class="nav-item nav-link m-2 sell-pending-nav-link asks_get" style="width: 10rem;" id="nav-profile-tab"
                   data-toggle="tab" href="#nav-home" role="tab"
                   aria-controls="nav-profile" aria-selected="false">My ASKS</a>

            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="table-responsive pt-4">
                    @include('flash::message')
                    <table class="table datatables">
                        <thead class="text-center text-white">
                        <tr>
                            <th scope="col" style="background-color: #2F2F2F; width: 15rem;border: 1px white solid;">
                                Item
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Bid
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Ask
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">Coupon</th>
                            {{-- <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Style
                            </th> --}}
                           {{--  <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Price
                            </th> --}}
                            {{-- <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Date
                            </th> --}}
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Status
                            </th>
                             <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Status
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Highest Bid
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Lowest Ask
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                                Expires
                            </th>
                            <th scope="col" style="background-color: #2F2F2F;border: 1px white solid;width: 10rem;">
                            	Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-center" style="background-color: #F8F8F8;">
	                       
                        
                        </tbody>
                    </table>
                </div>
                <a href="{{route('seller.portfolio.search')}}" class="btn p-2 rounded-0 border-0 shadow font-weight-bold" style="width: 12rem;background-color: #EFEFEF;font-size: 12px;">
                        ADD PRODUCT <img class="pl-3" src="{{asset('assets/img/icons/Group 649.png')}}">
                </a>
            </div>
           

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@include('admin.js-css-blades.datatables')
@section('cssheader')
@endsection
@section('jsfooter')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.datatables').css('width','100%');
			var datatbl = $('.datatables').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{route('seller.portfolio.get-user-bids')}}",
			    "aaSorting": [],
				columns: [
				    {data: 'product.product_name',name:'product.product_name'},
                    {data: 'bid',name:'bid',},
					
                    {data: 'ask',name:'ask',},
					{data: 'coupon',name:'coupon',orderable:false,searchable:false},
					{data: 'bid_status',name:'bid_status',},
					{data: 'ask_status',name:'ask_status',},
					{data: 'highest_bid',name:'highest_bid',orderable:false,searchable:false},
					{data: 'lowest_ask',name:'lowest_ask',orderable:false,searchable:false},
				    {data: 'expires_at',name:'expires_at'},
				    // {data: 'expires_at',name:'expires_at'},
				    // {data: 'expires_at',name:'expires_at'},
                  
				    {data: 'action',name:'action',orderable:false,searchable:false},
				]
			});
		    datatbl.column(2).visible(false);
		    datatbl.column(5).visible(false);
		    // datatbl.column(4).visible(false);
		    $('.bids_get').click(function(){
		    	datatbl.column(2).visible(false);
		    	datatbl.column(1).visible(true);
		    	datatbl.column(6).visible(true);
                datatbl.column(4).visible(true);
		    	datatbl.column(5).visible(false);
		    	datatbl.column(3).visible(true);

		    	datatbl.ajax.url('{{ route('seller.portfolio.get-user-bids') }}').draw();
		    });
		    $('.asks_get').click(function(){
		    	datatbl.column(1).visible(false);
		    	datatbl.column(2).visible(true);
		    	datatbl.column(4).visible(false);
                datatbl.column(5).visible(true);
		    	datatbl.column(6).visible(false);
		    	datatbl.column(3).visible(false);
		    	datatbl.ajax.url('{{ route('seller.portfolio.get-user-asks') }}').draw(); 
	    	})
		});
	</script>
@endsection