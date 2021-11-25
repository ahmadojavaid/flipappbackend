<div class="tab-pane show active" id="timeline">
    <div class="row" style="padding-left: 15px;padding-right: 15px;margin-right: -22px;margin-left: -20px;">
        <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Active Bids"></i>
                <h4 class="mt-0 font-16">Buying</h4>
                <h2 class="text-primary my-3 text-center active_bid_a">{{$total_product_sale_buying->t_id}}</h2>
            </div>
        </div>
         <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Expire Bids"></i>
                <h4 class="mt-0 font-16">Selling</h4>
                <h2 class="text-primary my-3 text-center">{{$total_product_sale_sellig->t_id}}</h2>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Active Asks"></i>
                <h4 class="mt-0 font-16">Total Buying Amount</h4>
                <h2 class="text-primary my-3 text-center active_ask_a">£ {{$total_product_sale_buying->t_amount}}</h2>
            </div>
        </div>
         <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Expire Asks"></i>
                <h4 class="mt-0 font-16">Total Selling Amount</h4>
                <h2 class="text-primary my-3 text-center">£ {{$total_product_sale_sellig->t_amount}}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-12" style="padding-left: 4px;padding-right: 4px;">
        <div class="card-box">

            <ul class="nav nav-tabs nav-bordered">
                <li class="nav-item buying_e">
                    <a href="#home-b1" data-toggle="tab" id="bids_get" aria-expanded="false" class="nav-link active">
                        Buying
                    </a>
                </li>
                <li class="nav-item selling_e">
                    <a href="#home-b1" data-toggle="tab" id="asks_get" aria-expanded="true" class="nav-link ">
                        Selling
                    </a>
                </li> 
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home-b1">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0 datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Total Amount</th>
                                    <th>Transaction Fee</th>
                                    <th>Payment Status</th>
                                    <th>Product Status</th>
                                    <th>Coupon</th>
                                    <th>Payment Recived Via</th>
                                    <th>Transaction Method</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

             
 
<script type="text/javascript">
    $(document).ready(function(){
        
        var datatbl = $('.datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.user.get_user_buying',$user->id) }}",
            "aaSorting": [],
            columns: [
                {data: 'product.product_name',name:'product.product_name',orderable:false,searchable:false},
                {data: 'sale_price',name:'sale_price',},
                {data: 'total_amount',name:'total_amount'},
                {data: 'transaction_fee',name:'transaction_fee'},
                {data: 'payment_status',name:'payment_status',orderable:false,searchable:false},
                {data: 'product_status',name:'product_status',orderable:false,searchable:false},
                {data: 'coupon_code',name:'coupon_code'},
                {data: 'prefered_payment_method',name:'prefered_payment_method',orderable:false,searchable:false},
                {data: 'user_payment_method_detail_id',name:'user_payment_method_detail_id'},
            ]
        });
        $('#DataTables_Table_0').css('width','100%');
        datatbl.column(7).visible(false);
        $('.buying_e').click(function(){
            datatbl.column(6).visible(true);
            datatbl.column(7).visible(false);
            datatbl.ajax.url('{{ route('admin.user.get_user_buying',$user->id) }}').draw();
        });
        $('.selling_e').click(function(){
            datatbl.column(6).visible(false);
            datatbl.column(7).visible(true);
            datatbl.ajax.url('{{ route('admin.user.get_user_selling',$user->id) }}').draw();
        });

    });
    
     
</script>
        