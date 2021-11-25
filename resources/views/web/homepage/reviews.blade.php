@extends('layouts.homepage.master')
@section('title', 'User Reviews')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">
        <section class="mb-5" style="background-color: #F6F6F6;">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0 faq-frequest-asked">
                        WHAT PEOPLE ARE SAYING ABOUT US
                    </p>
                </div>
            </div>
        </section>

        <div class="row mb-5">
            <div class="col">
                <div class="card bg-dark text-white rounded-0 border-0">
                    <img src="{{ asset('assets/img/backgrounds/Group%20899.png') }}" class="card-img img-fluid review-card-first-size" alt="...">
                    <div class="card-img-overlay p-0 border-0">
                        <div class="row">
                            <div class="col-sm-12 col-md-2">
                                <img src="{{ asset('assets/img/others/Mask%20Group%2095.png') }}" class="card-img  review-first-card-img" alt="...">
                            </div>
                            <div class="col-sm-12 col-md-10 pl-xs-4  card-text-first-padding" style="padding-right: 150px;padding-top: 30px;">
                                <p class="font-weight-bold review-card-first-text-size" style="font-size: 22px;">Julie Sanders</p>
                                <div class="d-flex flex-row justify-content-start review-card-first-text-size">
                                    <div>
                                        <img src="{{ asset('assets/img/icons/asset1.png') }}">
                                    </div>
                                    <div>
                                        <p class="" style="color: #CBCBCB; padding-top: 22px;padding-left: 6px;">
                                            Duis mauris augue, efficitur eu arcu sit amet, posuere dignissim neque. Aenean enim sem, pharetra et magna sit
                                            amet, luctus
                                            aliquet nibh. Curabitur auctor leo et libero consectetur gravida. Morbi gravida et sem dictum varius. Proin eget
                                            viverra sem,
                                            non euismod est. Maecenas facilisis urna in lectus aliquet venenatis. Etiam et metus nec mauris condimentum
                                            vulputate. Aenean
                                            volutpat odio quis egestas tempus. Fusce tempor vulputate luctus. Pellentesque vulputate viverra ex eget elementum.
                                            Aliquam
                                            ut feugiat felis.
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column justify-content-end">
                                        <img src="{{ asset('assets/img/icons/asset1.png') }}">
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <section class="review-other-section mb-5" style="background-color: #EBEBEB;">
            <div class="row">
                <div  style="padding-top: 5rem;" class="col-sm-12 col-md-6">
                    <div class="card review-card-other-style border-0 rounded-0">
                        <div class="card-body text-center text-white">
                            <div>
                                <img class="img-fluid rounded-circle review-card-img-other" src="{{ asset('assets/img/others/Mask%20Group%2095.png') }}">
                            </div>
                            <p class="mb-3 mt-3 font-weight-bold">Julie Sanders</p>
                            <div class="d-flex flex-row justify-content-center">

                                <div class="p-1">
                                    <img style="margin-top: -15px;" src="{{ asset('assets/img/icons/asset1-ohter.png') }}">
                                </div>

                                <div class="p-1">
                                    <p class="mb-0 text-left" style="color: #CBCBCB;">Duis mauris augue, efficitur eu arcu sit amet, posuere dignissim neque. Aenean enim sem, pharetra et magna sit amet,
                                        luctus aliquet nibh. </p>
                                </div>


                                <div class="p-1 d-flex flex-column  justify-content-end">
                                    <img class="justify-content-end" style="margin-top: 46px;" src="{{ asset('assets/img/icons/asset1-ohter.png') }}">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div style="padding-top: 5rem;" class=" col-sm-12 col-md-6">
                    <div class="card review-card-other-style border-0 rounded-0">
                        <div class="card-body text-center text-white">
                            <div>
                                <img class="img-fluid rounded-circle review-card-img-other" src="{{ asset('assets/img/others/Mask%20Group%2095.png') }}">
                            </div>
                            <p class="mb-3 mt-3 font-weight-bold">Julie Sanders</p>
                            <div class="d-flex flex-row justify-content-center">

                                <div class="p-1">
                                    <img style="margin-top: -15px;" src="{{ asset('assets/img/icons/asset1-ohter.png') }}">
                                </div>

                                <div class="p-1">
                                    <p class="mb-0 text-left" style="color: #CBCBCB;">Duis mauris augue, efficitur eu arcu sit amet, posuere dignissim neque. Aenean enim sem, pharetra et magna sit amet,
                                        luctus aliquet nibh. </p>
                                </div>


                                <div class="p-1 d-flex flex-column  justify-content-end">
                                    <img class="justify-content-end" style="margin-top: 46px;" src="{{ asset('assets/img/icons/asset1-ohter.png') }}">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="row" style="margin-bottom: 5rem;">
            <div class="col text-center">
                <button class="btn rounded-0 border-0 p-2 text-white shadow-none" style="background-color: #000000;width: 10rem">
                    MORE REVIEWS
                </button>
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