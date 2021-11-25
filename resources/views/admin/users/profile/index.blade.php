@extends('admin.layout.index')
@section('content')
    {{ Breadcrumbs::render('u-profile',$user->id) }}
	
	<div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">

                <h4 class="mb-0">{{$user->first_name}} {{$user->last_name}}</h4>
                <p class="text-muted"> {{(!empty($user->user_name)) ? '@'.$user->user_name : ''}}</p>
                <div class="text-left mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{$user->email}}</span></p>
                    <p class="text-muted mb-2 font-13"><strong>Email Status :</strong> <span class="ml-2 badge {{(!empty($user->email_verified_at)) ? 'badge-success' : 'badge-danger'}} badge-pill">{{(!empty($user->email_verified_at)) ? 'Verified' : 'Not Verified'}}</span></p>
                    <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2">{{$user->phone_number}}</span></p>
                    <p class="text-muted mb-2 font-13"><strong>Country :</strong> <span class="ml-2">{{$user->country}}</span></p>
                    <p class="text-muted mb-2 font-13"><strong>Social Login :</strong> <span class="ml-2">{{($user->provider) ? ucfirst($user->provider) : '-'}}</span></p>
                </div>

                 
            </div> <!-- end card-box -->

            <div class="card-box">
                <h4 class="header-title mb-3">Conversation's</h4>

                <div class="inbox-widget slimscroll" style="max-height: 310px;">
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Tomaslau</p>
                        <p class="inbox-item-text">I've finished it! See you so...</p>
                        
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Stillnotdavid</p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                        
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Kurafire</p>
                        <p class="inbox-item-text">Nice to meet you</p>
                        
                    </div>

                    <div class="inbox-item">
                        <div class="inbox-item-img"><img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" alt=""></div>
                        <p class="inbox-item-author">Shahedk</p>
                        <p class="inbox-item-text">Hey! there I'm available...</p>
                        
                    </div>
                    
                </div> <!-- end inbox-widget -->

            </div> <!-- end card-box-->

        </div> <!-- end col-->

        <div class="col-lg-8 col-xl-8">
            <div class="card-box">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item tabs_e" data-href="{{route('admin.user.page',['bids_asks',$user->id])}}">
                        <a href="#aboutme" id="aboutme_i" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Bids & Asks
                        </a>
                    </li>
                    <li class="nav-item tabs_e" data-href="{{route('admin.user.page',['buying_selling',$user->id])}}">
                        <a href="#timeline" id="buying_e" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            Buying & Selling
                        </a>
                    </li>
                    {{-- <li class="nav-item tabs_e" data-href="">
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                            Settings
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content html">
                     
                </div>
                <div class="row ">
                    <div class="spinner_center" style="margin: auto !important;">
                        <div class="spinner-grow spinner-grow-large spinner_f "  role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('admin.js-css-blades.datatables')
@include('admin.js-css-blades.sweetalert')
@section('script')
@parent
<script type="text/javascript">
    $(document).ready(function(){
       $('.tabs_e').click(function(){
             $('.spinner_f').removeClass('hide');
             $('.html').html('');
            var href = $(this).data('href');
            $.ajax({
               type:'GET',
               url:href,
               success:function(data) { 
                 $('.html').html(data);
                 $('.spinner_f').addClass('hide');
                 $('.af_spinner').removeClass('hide');
                 $('.spinner_f').addClass('hide');
               }
            });
        });
        $.ajax({
           type:'GET',
           url:"{{route('admin.user.page',['buying_selling',$user->id])}}",
           success:function(data) { 
             $('.html').html(data);
             $('.spinner_f').addClass('hide');
           }
        });
    });
    
     
</script>
@endsection