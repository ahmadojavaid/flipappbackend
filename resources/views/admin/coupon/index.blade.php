@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('coupon') }}
	 

	<div class="row">
        <div class="col-12">
        	@include('flash::message')
            <!-- <div class="card-box"> -->
                <div class="row">
                    <div class="col-lg-8">
                         
                    </div>
                    <div class="col-lg-4">
                        <div class="text-lg-right mt-3 mt-lg-0"> 
                            <a href="{{route('admin.coupon.create')}}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle mr-1"></i> Add Coupon</a>
                        </div>
                    </div><!-- end col-->
                </div> <!-- end row -->
            <!-- </div> end card-box -->
        </div> <!-- end col-->
    </div>

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
                        	<th>Name</th>
                            <th>Code</th>
                            <th>Maximum uses</th>
                            <th>Amount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Applicable</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->

            </div> <!-- end card-box -->
        </div>
    </div>

    @include('admin.js-css-blades.datatables')
	@include('admin.js-css-blades.sweetalert')
@endsection

@section('script')
@parent
<script type="text/javascript">
	$(document).ready(function(){
	 
	var datatbl = $('.datatables').DataTable({
	processing: true,
	serverSide: true,
	ajax: "{{ route('admin.coupon.get_coupons') }}",
    "aaSorting": [],
	columns: [
        {data: 'name',name:'name'},
    	{data: 'code',name:'code',},
    	{data: 'max_uses',name:'max_uses'},
        {data: 'discount_amount',name:'discount_amount'},
        {data: 'starts_at',name:'starts_at'},
        {data: 'expires_at',name:'expires_at'},
        {data: 'coupon_applicable',name:'coupon_applicable'},
        {data: 'action',"orderable": false,"searchable": false},
	]
	});
     $(document).on('click','#sa-title',function () {
       // return false;
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
      })
    })
});
	 
</script>
@endsection