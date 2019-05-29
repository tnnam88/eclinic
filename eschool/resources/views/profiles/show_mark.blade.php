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
                                <div class="central-meta">
                                    <h5 class="f-title"><i class="ti-info-alt"></i> Your Performance</h5>
                                    <p style="color: #088dcd;font-size: 22px">Your Subject : {{$subj}} </p>
                                    <p style="color: #088dcd;font-size: 22px">Your Level : {{$lv}}</p>
                                    <div id="linechart" style="width: 900px; height: 500px"></div>
                                    <div id="timechart" style="width: 900px; height: 500px"></div>
                                    <div id="warning" style="display: none"><p>Not enough test to show your performance (Minimum required : 3)</p></div>
                                </div><!-- show_mark -->

                                <div class="central-meta">
                                    <h5 class="f-title"><i class="ti-info-alt"></i> Check Your Performance</h5>

                                    <form method="post" action="{{url('showmark')}}">
                                        @csrf
                                        <div class="col-md-12">
                                            <div class="col-md-4"></div>
                                            <div class="form-group col-md-4">
                                                <label for="name">Select Subject :</label>
                                                <select name="subject_id" required>
                                                    <option value="" selected disabled hidden>Choose here</option>
                                                    @foreach ($subject as $sub)
                                                        <option value="{{ $sub->id }}">{{$sub->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4"></div>
                                            <div class="form-group col-md-4">
                                                <label for="name">Select Level :</label>
                                                <select name="level_id" required>
                                                    <option value="" selected disabled hidden>Choose here</option>
                                                    @foreach ($level as $lv)
                                                        <option value="{{ $lv->id }}">{{$lv->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="mtr-btn"><span>Check Now !</span></button>

                                    </form>
                                </div>
                                <script>
                                    function ShowDiv() {
                                        document.getElementById("user_mark").style.display = "";
                                    }
                                    var visitor = <?php echo $visitor; ?>;
                                    var time_count = <?php echo $time_count; ?>;
                                    console.log(visitor);
                                    console.log(time_count);
                                    google.charts.load('current', {'packages':['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);
                                    function drawChart() {
                                        var data = google.visualization.arrayToDataTable(visitor);
                                        var data2 = google.visualization.arrayToDataTable(time_count);


                                        var options = {
                                            title: 'Your Score ',
                                            vAxis: {title: 'Score',
                                                minValue: 0,
                                                viewWindow:{
                                                    max:20,
                                                    min:0
                                                },
                                                ticks: [0,2,4,6,8,10,12,14,16,18,20],
                                            },
                                            hAxis:{title: 'Date Completed'},
                                            legend: {position: 'bottom'},
                                            trendlines: {
                                                0: {
                                                    type: 'linear',
                                                    color: 'green',
                                                    lineWidth: 3,
                                                    opacity: 0.3,
                                                    showR2: true,
                                                    visibleInLegend: true
                                                }
                                            }
                                        };

                                        var options2 = {
                                            title: 'Your Time Doing Test ',
                                            vAxis: {title: 'Time Complete (s)',
                                                minValue: 0,
                                                viewWindow:{
                                                    max:200,
                                                    min:0
                                                },
                                                ticks: [0,20,40,60,80,100,120,140,160,180,200],
                                            },
                                            hAxis:{title: 'Date Completed'},
                                            legend: {position: 'bottom'},
                                            curveType:'function',
                                            colors:['red'],
                                            trendlines: {
                                                0: {
                                                    type: 'linear',
                                                    color: 'green',
                                                    lineWidth: 3,
                                                    opacity: 0.3,
                                                    showR2: true,
                                                    visibleInLegend: true
                                                }
                                            }
                                        };
                                        var chart = new google.visualization.LineChart(document.getElementById('linechart'));
                                        var chart2 = new google.visualization.LineChart(document.getElementById('timechart'));
                                        chart.draw(data, options);
                                        chart2.draw(data2, options2);
                                    }
                                    if (visitor.length<3){
                                        document.getElementById('linechart').style.display = "none";
                                        document.getElementById('timechart').style.display = "none";
                                        document.getElementById('warning').style.display = "block";
                                    }else {
                                        document.getElementById('warning').style.display = "none";
                                    }


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
