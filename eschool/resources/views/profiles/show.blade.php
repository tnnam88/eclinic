<?php
use App\Post;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;
?>
        <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Eschool Uruk Babylon</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="{{asset('css/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/color.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>
<body>
<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">

@include('layouts.header')<!-- responsive header -->

    <section>
        <div class="gap gray-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row" id="page-contents">
                        @include('layouts.lsidebar')<!-- sidebar -->
                            <div class="col-lg-6"><!-- center -->
                                @if (Session::has('success'))
                                    <div class="alert alert-success">
                                        <p>{{ \Session::get('success') }}</p>
                                    </div><br />
                                @endif

                                <div class="central-meta">
                                    <div class="editing-info">
                                        <p class="f-title"><i class="ti-info-alt"></i> Your Profile</p>

                                        <div class="user_pic">
                                            <img class="img-thumbnail" src="{{URL::asset('avatars/'.Auth::user()->filename)}}" alt="{{Auth::user()->original_filename}}">
                                        </div>

                                        <div class="form-group half show_profile" >
                                            <p style="color: #088dcd;font-size: 22px">Your Username</p><i class="mtrl-select"></i>
                                            <input type="text" id="input" readonly placeholder="{{$currentuser->name}}">
                                        </div>
                                        <div class="form-group half show_profile">
                                            <p style="color: #088dcd;font-size: 22px">Your Email</p><i class="mtrl-select"></i>
                                            <input type="text" id="input" readonly placeholder="{{$currentuser->email}}">
                                        </div>
                                        <div class="form-group half show_profile">
                                            <p style="color: #088dcd;font-size: 22px">Your Height</p><i class="mtrl-select"></i>
                                            <input type="text" id="input" readonly placeholder="{{$currentuser->height}} cm">

                                        </div>
                                        <div class="form-group half show_profile">
                                            <p style="color: #088dcd;font-size: 22px">Your Weight</p><i class="mtrl-select"></i>
                                            <input type="text" id="input" readonly placeholder="{{$currentuser->weight}} kg">

                                        </div>
                                        <div class="form-group half show_profile">
                                            <p style="color: #088dcd;font-size: 22px">Your Birthday</p><i class="mtrl-select"></i>
                                            <input type="text" id="input" readonly placeholder="{{$currentuser->dob}}">

                                        </div>
                                        <div class="form-group half show_profile">
                                            <p style="color: #088dcd;font-size: 22px">Your City</p><i class="mtrl-select"></i>
                                            <input type="text" id="input" readonly placeholder="{{$currentuser->city}}">

                                        </div>

                                        <a href="{{route('profiles.edit')}}"><button type="button" class="mtr-btn"><span>Edit Your Profile</span></button></a>



                                    </div>
                                </div>




                                <script>


                                </script>


                            </div><!-- center-->
                        @include('layouts.rsidebar')<!-- sidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('layouts.footer')<!-- responsive footer -->
</div>
@include('layouts.side-panel')<!-- side panel -->

<script data-cfasync="false" src={{asset('js/email-decode.min.js')}}></script>
<script src={{asset('js/main.min.js')}}></script>
<script src={{asset('js/script.js')}}></script>
<script src={{asset('js/map-init.js')}}></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script>

</body>
</html>