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
                        <th>Transaction Fee</th>
                        <th>Total</th>
                        <th>Expire Date</th>
                        <th>Ask Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div> <!-- end table-responsive-->

        </div> <!-- end card-box -->
    </div>
</div>
               
@section('script')
@parent
<script type="text/javascript">
	$(document).ready(function(){
	 
	var datatbl = $('.datatables').DataTable({
	processing: true,
	serverSide: true,
	ajax: "{{ route('admin.bids_asks.get_product_by_size') }}",
    "aaSorting": [],
	columns: [
    {data: 'product.product_name',name:'product.product_name'},
	{data: 'product.brand_name.brand_name',name:'product.brand_name.brand_name',},
	{data: 'product.color_way',name:'product.color_way'},
    {data: 'productTypeSize.name',name:'productTypeSize.name'},
    {data: 'product.publish_date',name:'product.publish_date'},
    {data: 'action',"orderable": false,"searchable": false},
	]
	});
     datatbl.on( 'draw', function () {
        $("select.input-sm").select2({
          containerCssClass : "dt-select"
        });
    });
     $("div.dataTables_length").parent().css({"flex-direction": "row"});
    $("div.dataTables_info").parent().css({"flex-direction": "row"});
});
	 
</script>
@endsection