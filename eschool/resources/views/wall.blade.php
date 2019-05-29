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
                    <span>1205 followers</span>
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
                                $wall_user = App\User::where('id',$wall_id)->first();
                                $wall_avatar = $wall_user->filename;
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
                                        <h5>{{$wall_user->name}}</h5>
                                        <span>{{$wall_user->role}}</span>
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
    <section><!-- main web-->
            <div class="gap gray-bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row" id="page-contents">
                            @include('layouts.lsidebar')<!-- lsidebar -->
                                <div class="col-lg-6"><!-- center -->

                                    {{ csrf_field() }}
                                    <div class="loadMore" id="post_data" data-wall="{{$wall_id}}"><!-- post & cmd -->




                                    </div><!-- post & cmd -->

                                </div><!-- center-->
                            @include('layouts.rsidebar')<!-- rsidebar -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @include('layouts.footer')<!-- responsive footer -->
</div>
@include('layouts.side-panel')<!-- side panel -->

<script data-cfasync="false" src="{{asset('js/email-decode.min.js')}}">

</script><script src="{{asset('js/main.min.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script>
    $(document).ready(function(){

        var _token = $('input[name="_token"]').val();
        wall_user_id={{$wall_id}};
        load_data('',wall_user_id, _token);


        function load_data(id="",wall_user_id='', _token)
        {
            $.ajax({
                url:"{{ route('wall') }}",
                method:"POST",
                data:{id:id,wall_user_id:wall_user_id, _token:_token},
                success:function(data)
                {
                    $('#load_more_button').remove();
                    $('#post_data').append(data);
                }
            });
        }

        $(document).on('click', '#load_more_button', function(){
            var id = $(this).data('id');
            $('#load_more_button').html('<b>Loading...</b>');
            load_data(id,wall_user_id, _token);
        });

        function load_cmt(id="", post_id="", _token)
        {
            $.ajax({
                url:"{{ route('loadcmt') }}",
                method:"POST",
                data:{id:id, post_id:post_id, _token:_token},
                success:function(data)
                {
                    $('#load_more_cmt'+post_id).remove();
                    // $('#new-cmt'+post_id).data('last_cmt')=
                    $('#post-cmt'+post_id).append(data);

                }
            });
        }

        $(document).on('click', '.load_more_cmt', function(){
            var id = $(this).data('id');
            var post_id = $(this).data('post');
            $(this).html('<b>Loading...</b>');
            load_cmt(id,post_id, _token);
        });

        function changelike(user_id="",cmt_id="",_token) {
            $.ajax({
                url:"{{route('changelike')}}",
                method:"POST",
                data:{user_id:user_id,cmt_id: cmt_id,_token:_token},
                success:function(data)
                {
                    $('#changelike'+cmt_id).html("");
                    $('#changelike'+cmt_id).append(data);
                    console.log(data);
                }
            });
        }


        $(document).on('click','.changelike',function () {
            var user_id = $(this).data('like_user');
            var cmt_id = $(this).data('like_cmt');
            changelike(user_id,cmt_id,_token);

        });


        function cmt(post_id="",top_cmt="",content="",_token) {
            $.ajax({
                url:"{{route('comment')}}",
                method:"POST",
                data:{post_id:post_id,top_cmt: top_cmt,content:content,_token:_token},
                success:function(data)
                {
                    $('.alert-cmt').remove();
                    $('#addcmt'+post_id).val('');
                    $('#load_more_cmt'+post_id).remove();
                    $('#post-cmt'+post_id+' li:nth-child(2)').after(data);

                }
            });
        }


        $(document).on('click','.new-cmt',function () {

            var post_id = $(this).data('p');
            var top_cmt = $('#post-cmt'+post_id+' li:nth-child(3)').data('cmt');
            var content = $('#addcmt'+post_id).val();
            if($('#addcmt'+post_id).val().length == 0)
            {
                alert("Plz Enter comment!");
                $('#addcmt'+post_id).after('<div class="alert alert-danger alert-cmt">\n' +
                    '  <strong>!!!</strong> Plz Enter Comment!\n' +
                    '</div>')

            }
            else {
                cmt(post_id,top_cmt,content,_token);
            }

        });
        function delpost(post_id="",_token) {
            $.ajax({
                url:"{{route('delpost')}}",
                method:"POST",
                data:{post_id:post_id,_token:_token},
                success:function(data)
                {
                    $('#post-cube-'+post_id).remove();
                    alert("Remove post success!!");
                }
            });
        }

        $(document).on('click','.del-post',function () {

            var confir = confirm("Press a button!");
            if(confir == true)
            {
                var post_id = $(this).data('post');
                delpost(post_id,_token);
            }
        });
        function delcmt(cmt_id="",_token) {
            $.ajax({
                url:"{{route('delcmt')}}",
                method:"POST",
                data:{cmt_id:cmt_id,_token:_token},
                success:function(data)
                {
                    $('#del-cmt'+cmt_id).remove();
                    alert("Remove post success!!");
                }
            });
        }

        $(document).on('click','.del-cmt',function () {

            var confir = confirm("Press a button!");
            if(confir == true)
            {
                var cmt_id = $(this).data('cmt');
                delcmt(cmt_id,_token);
            }
        });







    });
</script><!-- ajax -->

</body>
</html>