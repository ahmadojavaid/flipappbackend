
 
        <meta charset="utf-8" />
        <title>Proxx</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="token" content="{{ csrf_token() }}">

        <!-- Plugins css -->
        <link href="{{asset('admin/assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/css/buttonLoader.css') }}">
        <style type="text/css">
                 
        </style>
        @section('css')
        @show
        
        
