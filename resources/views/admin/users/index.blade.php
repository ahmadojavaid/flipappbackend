@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('users') }}
	 

	<div class="row">
        <div class="col-12">
        	@include('flash::message')
            <!-- <div class="card-box"> -->
                <div class="row">
                    <div class="col-lg-8">
                         
                    </div>
                    <div class="col-lg-4">
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
                        	<th></th>
                        	<th>First Name</th>
                            <th>Last Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Social Login</th>
                            <th>Email Status</th>
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
@endsection

@section('script')
@parent
<script type="text/javascript">
	$(document).ready(function(){
	 
	var datatbl = $('.datatables').DataTable({
	processing: true,
	serverSide: true,
	ajax: "{{ route('admin.user.get_users') }}",
    "order": [[ 0, "desc" ]],
	columns: [
	    {data: 'created_at',name:'created_at'},
	    {data: 'first_name',name:'first_name'},
		{data: 'last_name',name:'last_name',},
		{data: 'user_name',name:'user_name'},
	    {data: 'email',name:'email'},
	    {data: 'provider',name:'provider'},
	    {data: 'email_verified_at',name:'email_verified_at',"orderable": false,"searchable": false},
	    {data: 'action',"orderable": false,"searchable": false},
	]
	});
	datatbl.column(0).visible(false);

    //  datatbl.on( 'draw', function () {
    //     $("select.input-sm").select2({
    //       containerCssClass : "dt-select"
    //     });
    // });
    //  $("div.dataTables_length").parent().css({"flex-direction": "row"});
    // $("div.dataTables_info").parent().css({"flex-direction": "row"});
});
	 
</script>
@endsection