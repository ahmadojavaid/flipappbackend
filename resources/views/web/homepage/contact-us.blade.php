@extends('layouts.homepage.master')
@section('title', 'Contact US')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">
        <section class="mb-5" style="background-color: #F6F6F6;">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0 faq-frequest-asked">
                        GET IN TOUCH WITH US
                    </p>
                </div>
            </div>
        </section>
        <section style="background-color: #F6F6F6;margin-bottom: 167px;">
            <div class="row">
                <div class="col-sm-12 col-md-5 text-center p-5">
                    <p style="font-size: 20px;" class="float-left">LEAVE A MESSAGE</p>
                    <form>
                        <div class="form-group">

                            <input type="email" class="form-control rounded-0 shadow-none border-0" id="Your email" aria-describedby="emailHelp"
                                   placeholder="Your email">

                        </div>
                        <div class="form-group">

                            <input type="text" class="form-control rounded-0 shadow-none border-0" id="subject" placeholder="Subjects">

                        </div>
                        <div class="form-group">

                            <textarea class="form-control shadow-none rounded-0 border-0" rows="5" style="resize: none;" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" class="btn p-2 float-right rounded-0 text-center text-white" style="background-color: #000000; width: 8rem;">SUBMIT
                        </button>
                    </form>
                </div>

                <div class="col-sm-12 col-md-7 ">
                    <div class="contact-container">
                        <img src="{{ asset('assets/img/backgrounds/Mask Group 99.png') }}" alt="Snow" class="img-fluid">

                        <div class="contact-centered">
                            <div class="card">
                                <div class="card-body p-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <div class="p-1">
                                            <img src="{{ asset('assets/img/icons/email-filled-closed-envelope.png') }}">
                                        </div>
                                        <div class="p-1">
                                            <p class="mb-0">support@proxx.com</p>
                                        </div>
                                        <div class="p-1">
                                            <hr class="m-1">
                                        </div>
                                        <div class="p-1">
                                            <div class="d-flex flex-row justify-content-center">
                                                <div class="p-2">
                                                    <a href="#"><img src="{{ asset('assets/img/icons/facebook-logo.png') }}"></a>
                                                </div>
                                                <div class="p-2">
                                                    <a href="#"><img src="{{ asset('assets/img/icons/twitter%20(1).png') }}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
@endsection
@section('cssheader')
@endsection
@section('jsfooter')
@endsection