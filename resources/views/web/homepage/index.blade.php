@extends('layouts.homepage.master')
@section('title', 'Home')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="index-img-container">
        <img src="{{ asset('assets/img/backgrounds/Group 333.png') }}" class="img-fluid index-background-img">

        <div class="index-img-text-centered">
            <h1 class="mb-3 index-buy-now-1" style="text-shadow: 2px 2px 2px #000000;">BUY NOW & SELL NOW</h1>
            <h4 class="mb-3 index-buy-now-2" style="text-shadow: 2px 2px 2px #000000;">BUY NOW & SELL NOW</h4>
            <div class="input-group mb-3 index-search-box">
                <input type="text" class="form-control border-0 rounded-0 shadow-none " placeholder="SEARCH FOR BRAND" aria-label="SEARCH FOR BRAND"
                       aria-describedby="basic-addon2">


                <div class="input-group-append">

						<span class="input-group-text index-search-btn border-0" id="basic-addon2">
							<img src="{{ asset('assets/img/icons/Line 92.png') }}" style="height: 20px;padding-right: 12px;">
							<i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>


    </div>

    <div class="container">
        <div class="row" style="margin-top: -44px;">
            <div class="col">
                <ul class="nav nav-tabs justify-content-center border-0" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link header-bg-transparent  active font-weight-bold nav_g " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" data-href="{{route('get_latest')}}">LATEST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link header-bg-transparent font-weight-bold nav_g" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" data-href="{{route('get_supreme')}}">SUPREME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link header-bg-transparent font-weight-bold nav_g" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-href="{{route('get_popular')}}" >POPULAR</a>
                    </li>
                </ul>

            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="tab-content html af_spinner" id="myTabContent">
                    {!! $html !!}
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

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
<script type="text/javascript">
    $(document).ready(function(){

        $('.nav_g').click(function(){
            $('.af_spinner').addClass('hide');
             $('.spinner_f').removeClass('hide');
            var href = $(this).data('href');
            $.ajax({
               type:'GET',
               url:href,
               success:function(data) { 
                 $('.html').html(data);
                 $('.af_spinner').removeClass('hide');
                 $('.spinner_f').addClass('hide');
               }
            });
        });
        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            $.get(url, function(data){
                $('.html').html(data);
            });
        });
    });
</script>
@endsection
