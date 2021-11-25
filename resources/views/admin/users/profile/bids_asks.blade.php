<div class="tab-pane" id="aboutme" style="display: block">
    <div class="row" style="padding-left: 15px;padding-right: 15px;margin-right: -22px;margin-left: -20px;">
        <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Active Bids"></i>
                <h4 class="mt-0 font-16">Active Bids</h4>
                <h2 class="text-primary my-3 text-center active_bid_a">{{$active_bids->total}}</h2>
            </div>
        </div>
         <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Expire Bids"></i>
                <h4 class="mt-0 font-16">Expires Bids</h4>
                <h2 class="text-primary my-3 text-center">{{$expire_bids->total}}</h2>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Active Asks"></i>
                <h4 class="mt-0 font-16">Active Asks</h4>
                <h2 class="text-primary my-3 text-center active_ask_a">{{$active_asks->total}}</h2>
            </div>
        </div>
         <div class="col-md-6 col-xl-3">
            <div class="card-box">
                <i class="fa fa-info-circle text-muted float-right" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Expire Asks"></i>
                <h4 class="mt-0 font-16">Expires Asks</h4>
                <h2 class="text-primary my-3 text-center">{{$expire_asks->total}}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-12" style="padding-left: 4px;padding-right: 4px;">
        <div class="card-box">

            <ul class="nav nav-tabs nav-bordered">
                <li class="nav-item">
                    <a href="#home-b1" data-toggle="tab" id="bids_get" aria-expanded="false" class="nav-link active">
                        Bids
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#home-b1" data-toggle="tab" id="asks_get" aria-expanded="true" class="nav-link ">
                        Asks
                    </a>
                </li> 
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home-b1">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0 datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ask</th>
                                    <th>Bid</th>
                                    <th>Transaction Fee</th>
                                    <th>Coupon</th>
                                    <th>Total</th>
                                    <th>Expire Date</th>
                                    <th>Bid Status</th>
                                    <th>Ask Status</th>
                                    <th>Action</th>
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
            ajax: "{{ route('admin.user.get_user_bids',$user->id) }}",
            "aaSorting": [],
            columns: [
                {data: 'ask',name:'ask',},
                {data: 'bid',name:'bid',},
                {data: 'transaction_fee',name:'transaction_fee'},
                {data: 'coupon',name:'coupon',orderable:false,searchable:false},
                {data: 'total',name:'total'},
                {data: 'expires_at',name:'expires_at'},
                {data: 'bid_status'},
                {data: 'ask_status'},
                {data: 'action',orderable:false,searchable:false},
            ]
        });
        $('#DataTables_Table_0').css('width','100%');
        datatbl.column(0).visible(false);
        datatbl.column(7).visible(false);
        $('#bids_get').click(function(){
            datatbl.column(0).visible(false);
            datatbl.column(1).visible(true);
            datatbl.column(3).visible(true);
            datatbl.column(6).visible(true);
            datatbl.column(7).visible(false);
            datatbl.ajax.url('{{ route('admin.user.get_user_bids',$user->id) }}').draw();
        });
        $('#asks_get').click(function(){
            datatbl.column(0).visible(true);
            datatbl.column(1).visible(false);
            datatbl.column(3).visible(false);
            datatbl.column(6).visible(false);
            datatbl.column(7).visible(true);
            datatbl.ajax.url('{{ route('admin.user.get_user_asks',$user->id) }}').draw();
        });

        $(document).on('click','.del_data',function(){
            var id = $(this).data('id');
            var url = $(this).data('href');
            var type = $(this).data('type');
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
            t.value ? 

                $.ajax({
                  url: url,
                  type:'GET',
                  success: function(response){
                    if(response.status == 1){
                        Swal.fire({
                          title: 'Success',
                          text: 'Data Deleted Successfully.',
                          type: 'success'
                        })
                        if(type == 'ask'){
                            datatbl.ajax.url('{{ route('admin.user.get_user_asks',$user->id) }}').draw();
                            $('.active_ask_a').html(response.ask);
                        }
                        if(type == 'bid'){
                            datatbl.ajax.url('{{ route('admin.user.get_user_bids',$user->id) }}').draw();
                            $('.active_bid_a').html(response.bid);
                        }
                    }

                    if(response.status == 0){
                        Swal.fire({
                          title: 'Error',
                          text: 'Something Went Wrong .',
                          type: 'error'
                        })
                    }
                  },    
                  dataType: 'json'
                })


              : t.dismiss === Swal.DismissReason.cancel && Swal.fire({
              title: 'Cancelled',
              text: 'Your Data is safe :)',
              type: 'error'
            })
      })
        });
    });
    function update(e){

        e.preventDefault();
        $('.has-spinner').buttonLoader('start');
        $('.spinner').removeClass('spinner');
        var form = $('#form');
        $.ajax({
            type: 'POST',
            url: form.attr("action"),
            data: form.serialize(),
            success: function(response) {
                if(response.status == 1){
                    $('.success_msgs').removeClass('hide');
                    $('.error_msgs').addClass('hide');
                    $('.success_msgs').html(`<ul><li>Record Updated Successfully</li></ul>`);
                    $('.has-spinner').buttonLoader('stop');

                }
                if(response.status == 0){
                    $('.success_msgs').addClass('hide');
                    $('.error_msgs').removeClass('hide');
                    $('.has-spinner').buttonLoader('stop');
                    $('.error_msgs').html(`<ul><li>Record Updated Successfully</li></ul>`);
                }
            },
            error: function (reject) {
                if( reject.status === 422 ) {
                     var errors = $.parseJSON(reject.responseText);
                    var hh = '<ul class="float_left">';
                    $.each(errors.errors, function (key, val) {
                        hh += '<li>' + val + '</li>';
                    });
                    hh += '</ul>';
                    $('.error_msgs').html(hh);
                    $('.error_msgs').removeClass('hide');
                    $('.success_msgs').addClass('hide');
                    $('.has-spinner').buttonLoader('stop');               

                }
            }
        });
    }
     
</script>
      