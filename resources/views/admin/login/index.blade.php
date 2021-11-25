<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/ubold/layouts/material/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Sep 2019 05:03:34 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Proxx</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <a href="index.html">
                                        <span><h3>Admin Login</h3></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                                </div>

                                <form action="{{route('post_admin_login')}}" method="post">
                                	@csrf
                                	@if (count($errors) > 0)
					                    <div class="alert alert-danger">
					                        <strong>Whoops!</strong> There were some problems with your input.
					                        <ul>
					                            @foreach ($errors->all() as $error)
					                                <li>{{ $error }}</li>
					                            @endforeach
					                        </ul>
					                    </div>
					                @endif
					                @include('flash::message')
                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" type="email" id="emailaddress" name="email"   placeholder="Enter your email">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" name="password" type="password" required="" id="password" placeholder="Enter your password">
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                                    </div>

                                </form>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!--  <footer class="footer footer-alt">
            2015 - 2019 &copy; UBold theme by <a href="#" class="text-white-50">Coderthemes</a> 
        </footer> -->

        <!-- Vendor js -->
        <script src="{{asset('admin/assets/js/vendor.min.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.min.js')}}"></script>
        
    </body>

<!-- Mirrored from coderthemes.com/ubold/layouts/material/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Sep 2019 05:03:34 GMT -->
</html>