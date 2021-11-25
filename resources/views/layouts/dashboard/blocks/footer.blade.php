<div id="footer">
    <section class="footer-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3">

                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <p class="mb-0" style="font-size: 48px;">Proxx</p>
                        </div>
                    </div>
                    <div class="row pt-4 pb-2">
                        <div class="col">

                        </div>
                        <div class="col-sm-12 col-md-2 p-sm-2">
                            <a class="mb-0 text-white text-decoration-none" href="{{ url('/faq') }}" >FAQ</a>
                        </div>
                        <div class="col-sm-12 col-md-3 p-sm-2">
                            <a class="mb-0 text-white text-decoration-none" href="{{ url('/how-it-works') }}">HOW IT WORKS</a>
                        </div>
                        <div class="col-sm-12 col-md-2 p-sm-2">
                            <a class="mb-0 text-white text-decoration-none" href="{{ url('/user-reviews') }}">REVIEWS</a>
                        </div>
                        <div class="col-sm-12 col-md-2 p-sm-2">
                            <a class="mb-0  text-white text-decoration-none" href="{{ url('/terms-and-conditions') }}">TERMS</a>
                        </div>
                        <div class="col-sm-12 col-md-2 p-sm-2">
                            <a class="mb-0 text-white text-decoration-none" href="{{ url('/contact-us') }}" >CONTACT</a>
                        </div>
                        <div class="col">

                        </div>
                    </div>

                    <div class="row pt-3 pb-3">
                        <div class="col text-center">


                            <button class="btn p-2 rounded-0 text-white" style="width: 11rem;border: 2px white solid;font-size: 14px;">GET THE APP<i class="fab fa-apple pl-3" style="font-size: 22px;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-sm-12 col-md-12">
                            <div class="d-flex flex-row justify-content-center">
                                <div class="p-2">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div class="p-2">
                                    <i class="fab fa-twitter"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col">
                            <hr class="bg-white m-0" style="">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col text-center">
                            <p class="mb-2" style="font-size: 14px;">2019 Proxx. All Rights Reserved</p>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-md-3">

                </div>
            </div>
        </div>
    </section>
</div>
</div>
<!--Script-->
<!--Script-->
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
<script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.buttonLoader.js') }}"></script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 
$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

</script>
@section('script')
        @show
@yield('jsfooter')

</body>
</html>