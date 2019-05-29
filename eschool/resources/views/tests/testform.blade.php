<?php
use App\Post;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\User;

$user = Auth::user();
$notifications = DB::table('notifications')
    ->where('receiver_id','=',$user->id)
    ->where('sender_id','!=',$user->id)
    ->where('checked','=',0)
    ->orderBy('id','DESC')
    ->limit(5)
    ->get();
$not_count = DB::table('notifications')
    ->where('receiver_id','=',$user->id)
    ->where('sender_id','!=',$user->id)
    ->where('checked','=',0)
    ->orderBy('id','DESC')
    ->count();
$activities = DB::table('notifications')
    ->where('sender_id','=',$user->id)
    ->where('checked','=',0)
    ->orderBy('id','DESC')
    ->limit(5)
    ->get();
$frs= User::all();


?>
<!DOCTYPE html>
<html lang="en">
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


    <style>
        .chosen-container-single .chosen-single {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border-color: -moz-use-text-color -moz-use-text-color #e1e8ed;
            border-radius: 0;
            border-style: solid;
            border-width: 1px;
            box-shadow: none;
            color: none !important;
            font-size: 16px;
            height: 35px;
            line-height: 35px;
            margin-bottom: 10px;

        }
        .select_test{
            background: #088dcd;
            border: medium none;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            padding: 3px 10px;
        }
    </style>

</head>
<body>
<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">

    @include('layouts.header')<!-- responsive header -->

        <section>
            <div class="feature-photo">
                <figure>
                    <img src="{{asset('images/resources/timeline-1.jpg')}}" alt=""></figure>
                <div class="add-btn">
                    <a href="#" title="" data-ripple="">Add Friend</a>
                </div>
                <form class="edit-phto">
                    <i class="fa fa-camera-retro"></i>
                    <label class="fileContainer">
                        Edit Cover Photo
                        <input type="file"/>
                    </label>
                </form>
                <div class="container-fluid">
                    <div class="row merged">
                        <div class="col-lg-2 col-sm-3">
                            <div class="user-avatar">
                                <?php
                                $wall_avatar = $user->filename;
                                ?>
                                <figure class="wall-avatar">
                                    <img src="{{asset('avatars/'.$wall_avatar)}}" alt="">
                                    <form class="edit-phto">
                                        <i class="fa fa-camera-retro"></i>
                                        <label class="fileContainer">
                                            Edit Display Photo
                                            <input type="file"/>
                                        </label>
                                    </form>
                                </figure>
                            </div>
                        </div>
                        <div class="col-lg-10 col-sm-9">
                            <div class="timeline-info">
                                <ul>
                                    <li class="admin-name">
                                        <h5>{{$user->name}}</h5>
                                        <span>{{$user->role}}</span>
                                    </li>
                                    <li>
                                        <a class="active" href="time-line.html" title="" data-ripple="">time line</a>
                                        <a class="" href="timeline-photos.html" title="" data-ripple="">Photos</a>
                                        <a class="" href="timeline-videos.html" title="" data-ripple="">Videos</a>
                                        <a class="" href="timeline-friends.html" title="" data-ripple="">Friends</a>
                                        <a class="" href="timeline-groups.html" title="" data-ripple="">Groups</a>
                                        <a class="" href="about.html" title="" data-ripple="">about</a>
                                        <a class="" href="#" title="" data-ripple="">more</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- top area -->

    <section>
        <div class="gap gray-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row" id="page-contents">
                            @include("layouts.lsidebar")<!-- lsidebar -->
                            <div class="col-lg-6">
                                <div class="central-meta">
                                    <div class="about">
                                        Select Your Free Option
                                        <div class="d-flex flex-row mt-2">
                                            <form class="" action="/test" method="get">
                                            <ul class="" >
                                                <li class="">
                                                    <p class="select_test">Select Class</p>
                                                    <select class="" name="testlvl_id" >
                                                        <?php
                                                        foreach($levels as $level) {
                                                            echo "<option value='$level->id'>$level->id/12</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </li>
                                                <li class="nav-item">
                                                    <p class="select_test">Select Subject</p>
                                                    <select class="" name="testsubject_id" >
                                                        <?php
                                                        foreach($subjects as $subject) {
                                                            echo "<option value='$subject->id'>$subject->name</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </li>
                                                <p><button class="">Do test</button></p>

                                            </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- centerl meta -->
                            @include("layouts.rsidebar")<!-- rsidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include("layouts.footer")<!-- footer -->
</div>
@include("layouts.side-panel")<!-- side panel -->

<script data-cfasync="false" src="js/email-decode.min.js"></script><script src="js/main.min.js"></script>
<script src="js/script.js"></script>
<script src="js/map-init.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script>

</body>
</html>