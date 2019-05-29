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
        <div class="gap gray-bg">
            <div class="container-fluid">
                <div class="row justify-content-center">
                @include('layouts.lsidebar')<!-- lsidebar -->

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ __('Register') }}</div>

                                <div class="card-body">
                                    <form method="POST" action="{{ route('adm_register') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                                            <div class="col-md-6">
                                                <input id="role" type="text" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" value="{{ old('role') }}" required autofocus>

                                                @if ($errors->has('role'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Register') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
<script src="{{asset('js/strip.pkgd.min.js')}}"></script>
<script>
    $(document).ready(function(){

        var _token = $('input[name="_token"]').val();

        load_data('', _token);

        function load_data(id="", _token)
        {
            $.ajax({
                url:"{{ route('showacc') }}",
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

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#page-contents .tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        function delpost(acc_id="",_token) {
            $.ajax({
                url:"{{route('delacc')}}",
                method:"POST",
                data:{acc_id:acc_id,_token:_token},
                success:function(data)
                {
                    $('#post-cube-'+acc_id).remove();
                    alert("Remove post success!!");
                }
            });
        }

        $(document).on('click','.del-post',function () {

            var confir = confirm("Press a button!");
            if(confir == true)
            {
                var acc_id = $(this).data('post');
                delpost(acc_id,_token);
            }
        });

        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }






    });
</script><!-- ajax -->

</body>
</html>
