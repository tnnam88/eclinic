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

    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">





</head>
<body>
<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">

    @include('layouts.header')<!-- responsive header -->

    <section><!-- main web-->
        <div class="gap gray-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row" id="page-contents">
                            @include('layouts.lsidebar')<!-- lsidebar -->
                            <div class="col-lg-6"><!-- center -->
                                    <div class="central-meta">
                                        <div class="new-postbox">
                                            <figure class="avatar">
                                                <?php
                                                $avatar = Auth::user()->filename;
                                                //                                            Image::make('avatars/'.$avatar)->resize(45,45)->save();
                                                ?>
                                                <img src="{{url('avatars/'.$avatar)}}" alt="{{$avatar}}">
                                            </figure>
                                            <div class="newpst-input">

                                                <form method="post" action="{{url('post')}}" enctype="multipart/form-data" >
                                                    @csrf
                                                    <textarea rows="1" placeholder="Title" name="title"></textarea>
                                                    <textarea rows="2" placeholder="Write something" name="content"></textarea>
                                                    <div class="attachments">
                                                        <ul>
                                                            {{--<li>--}}
                                                            {{--<i class="fa fa-music"></i>--}}
                                                            {{--<label class="fileContainer">--}}
                                                            {{--<input type="file">--}}
                                                            {{--</label>--}}
                                                            {{--</li>--}}
                                                            <li>
                                                                <i class="fa fa-image fa-2x"></i>
                                                                <label class="fileContainer">
                                                                    <input type="file" name="photo">
                                                                </label>
                                                            </li>
                                                            {{--<li>--}}
                                                            {{--<i class="fa fa-video-camera"></i>--}}
                                                            {{--<label class="fileContainer">--}}
                                                            {{--<input type="file">--}}
                                                            {{--</label>--}}
                                                            {{--</li>--}}
                                                            {{--<li>--}}
                                                            {{--<i class="fa fa-camera"></i>--}}
                                                            {{--<label class="fileContainer">--}}
                                                            {{--<input type="file">--}}
                                                            {{--</label>--}}
                                                            {{--</li>--}}
                                                            <li>
                                                                <button type="submit">Post</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger" style="margin-top: 50px">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div><br />
                                        @endif
                                        @if (\Session::has('success'))
                                            <div class="alert alert-success" style="margin-top: 50px">
                                                <p>{{ \Session::get('success') }}</p>
                                            </div><br />
                                        @endif
                                    </div><!-- add post -->
                                    {{ csrf_field() }}
                                    <div class="loadMore" id="post_data"><!-- post & cmd -->




                                    </div><!-- post & cmd -->

                                </div><!-- center-->
                            @include('layouts.rsidebar')<!-- rsidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <div id="auto10">

        </div>

    @include('layouts.footer')<!-- responsive footer -->
</div>

@include('layouts.side-panel')<!-- side panel -->

<script data-cfasync="false" src={{asset('js/email-decode.min.js')}}></script>
<script src={{asset('js/main.min.js')}}></script>
<script src={{asset('js/script.js')}}></script>
<script src={{asset('js/map-init.js')}}></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script>
<script>
    $(document).ready(function(){

        var _token = $('input[name="_token"]').val();

        load_data('', _token);

        function load_data(id="", _token)
        {
            $.ajax({
                url:"{{ route('loadpost') }}",
                method:"POST",
                data:{id:id, _token:_token},
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
            load_data(id, _token);
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

        // setInterval(function(){ alert("Hello"); }, 3000);








    });
</script>

</body>
</html>

