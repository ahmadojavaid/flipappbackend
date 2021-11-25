@extends('layouts.homepage.master')
@section('title', 'Get our app')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">

        <section class="pl-5 pt-5 pb-3 app-bg-black-section">
            <div class="row">

                <div class="col-sm-12 col-md-3  text-white ">
                    <p class="mb-0 font-weight-bold " style="font-size: 20px;">GET THE</p>
                    <p class="mb-0 " style="font-size: 60px;">PROXX</p>
                    <p class="mb-0 font-weight-bold " style="font-size: 20px;">APP FOR IPHONE</p>
                </div>

            </div>
        </section>

        <div class="row" style="margin-bottom: 5rem;">
            <div class="col-sm-12 col-md-6 ">
                <section class="mt-4 pl-5 pt-5 pb-4" style="background-color: #F6F6F6">
                    <p class="font-weight-bold mb-3" style="font-size: 23px;">Buy and Sell from your pocket.</p>
                    <button class="btn rounded-0 border-0 p-3 text-white shadow-none" style="background-color: #000000;width: 13rem;height: 3.5rem;font-size: 19px;">
                        GET THE APP <i class="fab fa-apple pl-2"></i>
                    </button>
                </section>
            </div>
            <div class="col-sm-12 col-md-6 text-center ">
                <img src="{{ asset('assets/img/backgrounds/Group%20595.png')}}" class="img-fluid app-mobile-phone-setting">
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
@endsection