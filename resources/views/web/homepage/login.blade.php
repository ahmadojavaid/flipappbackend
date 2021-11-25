@extends('layouts.homepage.master')
@section('title', 'Login/SignUp')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="container">
        @if(Session::has('message'))
            <div class="alert">
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                <script>
                    setTimeout(function(){
                        $('div.alert').toggle(1000);
                    },3500);
                </script>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs justify-content-center border-bottom-0" id="myTab" role="tablist">

                    <li class="nav-item text-center" style="width: 23rem;">
                        <a class="nav-link  sign-up-navtab-nav-link active" id="SIGN-UP-tab" data-toggle="tab" href="#SIGN-UP" role="tab" aria-controls="SIGN-UP" aria-selected="true">SIGN UP</a>
                    </li>
                    <li class="nav-item text-center" style="width: 23rem;">
                        <a class="nav-link sign-up-navtab-nav-link" id="LOGIN-tab" data-toggle="tab" href="#LOGIN" role="tab" aria-controls="LOGIN" aria-selected="false">LOGIN</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="SIGN-UP" role="tabpanel" aria-labelledby="SIGN-UP-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-2">

                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="row pt-4">


                                    <div class="col-sm-12 col-md-6">
                                        <a href="{{route('facebook_signin')}}">
                                            <img src="{{ asset('assets/img/icons/Group%20898.svg') }}" class="img-fluid">
                                        </a>


                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <a href="{{route('twitter_signin')}}">
                                            <img src="{{ asset('assets/img/icons/Group 466.svg') }}" class="img-fluid">
                                        </a>


                                    </div>

                                </div>
                                @include('flash::message')
                                <div class="row p-5">
                                    <div class="col text-center">
                                        <div class="alert alert-success hide success_msgs" role="alert">

                                        </div>
                                        <div class="alert alert-danger  hide error_msgs" role="alert">

                                        </div>
                                        <form method="POST" action="{{ url('/user-signup') }}" id="signup_form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="first_name"  placeholder="First Name" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="last_name"  placeholder="Last Name" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="user_name"  placeholder="User Name" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="email"  placeholder="Email" required >
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="phone_number"  placeholder="Phone Number" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="country"  placeholder="Country"  >
                                            </div>
                                            <div class="form-group">
                                                <input type="password" id="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="password"  placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none" name="password_confirmation"  placeholder="Confirm Password" id="confirm_password" required>
                                                <p id="message"></p>
                                            </div>

                                            <button type="submit" id="signup_btn" class="btn btn-dark rounded-0 has-spinner border-0 mt-4 mb-5" style="width: 10rem;">SIGN UP

                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="LOGIN" role="tabpanel" aria-labelledby="LOGIN-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-2">

                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="row pt-4">


                                    <div class="col-sm-12 col-md-6">
                                        <a href="{{route('facebook_signin')}}">
                                            <img src="{{ asset('assets/img/icons/Group%20898.svg') }}" class="img-fluid">
                                        </a>


                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <a href="{{route('twitter_signin')}}">
                                            <img src="{{ asset('assets/img/icons/Group 466.svg') }}" class="img-fluid">
                                        </a>


                                    </div>
                                </div>
                                <div class="row p-5">
                                    <div class="col ">
                                        <div class="alert alert-danger  hide error_msgs_signin" role="alert">

                                        </div>
                                        <form class="text-center" action="javascript:;" id="sign_in-form" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control border-top-0 border-right-0 border-left-0 shadow-none"  placeholder="Email" required>
                                            </div>

                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control border-top-0 border-right-0 border-left-0 shadow-none"  placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{route('password.reset')}}" class="pt-2 pb-2 " style="color: #2F2F2F;">Forgot Your Password</a>
                                            </div>
                                            <br>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-dark rounded-0 border-0 has-spinnerr" style="width: 10rem;">LOGIN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2">

                            </div>
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

        $('.error_msgs').addClass('hide');
        $('.success_msgs').addClass('hide');

        $('#password, #confirm_password').on('keyup', function () {

          if ($('#password').val() == $('#confirm_password').val()) {
            $("#signup_btn").attr("disabled", false);
            $('#message').html('Password Matched').css({'float' : 'left','color' :  'green'});
          } else {
            $('#message').html('Not Matching').css({'float' : 'left','color' :  'red'});
            $("#signup_btn").attr("disabled", true);
          }

        });

        $("#signup_form").submit(function(e){
            e.preventDefault(e);

            $('.has-spinner').buttonLoader('start');
            $.ajax({
                url     : "{{ url('/user-signup') }}",
                method  : 'post',
                data    : $(this).serialize(),
                success : function(response){
                    if(response.status == 1){
                        $('.has-spinner').buttonLoader('stop');
                        $('.success_msgs').removeClass('hide');
                        $('.error_msgs').addClass('hide');
                        $('.success_msgs').html('<ul><li>'+response.message+'</li></ul>');
                        $("#signup_form").trigger("reset");
                        $('#message').html('');
                        setTimeout(function(){ window.location = "{{route('verification.notice')}}"; }, 3000);

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
        });

        $("#sign_in-form").submit(function(e){
            e.preventDefault(e);
            $('.has-spinnerr').buttonLoader('start');


            $('.error_msgs_signin').addClass('hide');
            $.ajax({

                url     : "{{ route('post_login') }}",
                method  : 'post',
                data    : $(this).serialize(),
                success : function(response){
                    
                    if(response.status == 1){
                        window.location = response.url;
                        $('.error_msgs_signin').addClass('hide');
                    }
                    if(response.status == 0){
                        $('.error_msgs_signin').html(response.message);
                        $('.error_msgs_signin').removeClass('hide');
                    }
                    $('.has-spinnerr').buttonLoader('stop');

                },
                error: function (reject) {
                if( reject.status === 422 ) {
                    $('.has-spinnerr').buttonLoader('stop');

                }
            }
            });
        });

    });

</script>
@endsection
