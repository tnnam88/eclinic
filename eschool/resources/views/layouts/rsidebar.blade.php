<?php
        use App\Post;
        use App\Comment;
        use App\Like;
$posts = Post::latest()->take(5)->get();
$id = \Auth::user()->id;
$recents = Post::where('user_id', '=', $id)->latest()->take(5)->get();
$posts_count = Post::where('user_id', '=', $id)->count();
$comment_count = Comment:: where('user_id', '=', $id)->count();
// Count all likes that an user received over time
$cmtbyid = Comment:: where('user_id', '=', $id)->get();
$like_all = 0;
foreach ($cmtbyid as $cmt) {
    $like_all += Like::where('comment_id', '=', $cmt->id)->count();
}
//Count only likes that an user received last 7 days
$date = \Carbon\Carbon::today()->subDays(7);
$cmtweek = Comment::where('user_id', '=', $id)->where('created_at', '>=', $date)->get();
$like_week = 0;
foreach ($cmtweek as $cmt) {
    $like_week += Like::where('comment_id', '=', $cmt->id)->count();
}

?>
<div class="col-lg-3">
    <aside class="sidebar static">
        <div class="widget">

        </div>
        <div class="widget">
            <h4 class="widget-title">Your page</h4>
            <div class="your-page">
                <figure>
                    <?php
                    $avatar = Auth::user()->filename;
                    ?>
                    <img src="{{url('avatars/'.$avatar)}}" alt="{{$avatar}}">
                </figure>
                <div class="page-meta">
                    <a href="#" title="" class="underline">{{Auth::user()->name}}</a>
                    <span><i class="ti-comment"></i><a href="insight.html" title="">Posts <em>{{$posts_count}}</em></a></span>
                    <span><i class="ti-bell"></i><a href="insight.html" title="">Comments <em>{{$comment_count}}</em></a></span>
                </div>
                <div class="page-likes">
                    <ul class="nav nav-tabs likes-btn">
                        <li class="nav-item"><a class="active" href="#link1" data-toggle="tab">this week</a></li>
                        <li class="nav-item"><a class="" href="#link2" data-toggle="tab">all time</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active fade show " id="link1" >
                            <span><i class="ti-heart"></i>{{$like_week}}</span>
                            <a href="#" title="weekly-likes">{{$like_week}} new likes this week</a>
                            <div class="users-thumb-list">
                                <a href="#" title="Anderw" data-toggle="tooltip">
                                    <img src="images/resources/userlist-1.jpg" alt="">
                                </a>
                                <a href="#" title="frank" data-toggle="tooltip">
                                    <img src="images/resources/userlist-2.jpg" alt="">
                                </a>
                                <a href="#" title="Sara" data-toggle="tooltip">
                                    <img src="images/resources/userlist-3.jpg" alt="">
                                </a>
                                <a href="#" title="Amy" data-toggle="tooltip">
                                    <img src="images/resources/userlist-4.jpg" alt="">
                                </a>
                                <a href="#" title="Ema" data-toggle="tooltip">
                                    <img src="images/resources/userlist-5.jpg" alt="">
                                </a>
                                <a href="#" title="Sophie" data-toggle="tooltip">
                                    <img src="images/resources/userlist-6.jpg" alt="">
                                </a>
                                <a href="#" title="Maria" data-toggle="tooltip">
                                    <img src="images/resources/userlist-7.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="link2" >
                            <span><i class="ti-heart"></i>{{$like_all}}</span>
                            <a href="#" title="weekly-likes">{{$like_all}} likes in total</a>
                            <div class="users-thumb-list">
                                <a href="#" title="Anderw" data-toggle="tooltip">
                                    <img src="images/resources/userlist-1.jpg" alt="">
                                </a>
                                <a href="#" title="frank" data-toggle="tooltip">
                                    <img src="images/resources/userlist-2.jpg" alt="">
                                </a>
                                <a href="#" title="Sara" data-toggle="tooltip">
                                    <img src="images/resources/userlist-3.jpg" alt="">
                                </a>
                                <a href="#" title="Amy" data-toggle="tooltip">
                                    <img src="images/resources/userlist-4.jpg" alt="">
                                </a>
                                <a href="#" title="Ema" data-toggle="tooltip">
                                    <img src="images/resources/userlist-5.jpg" alt="">
                                </a>
                                <a href="#" title="Sophie" data-toggle="tooltip">
                                    <img src="images/resources/userlist-6.jpg" alt="">
                                </a>
                                <a href="#" title="Maria" data-toggle="tooltip">
                                    <img src="images/resources/userlist-7.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- page like widget -->
        
        <div class="widget friend-list stick-widget">
            <h4 class="widget-title">Friends</h4>
            <div id="searchDir"></div>
            <ul id="people-list" class="friendz-list">
                @foreach($frs as $fr)
                    @if($fr->id != Auth::user()->id)
                <li>
                    <figure class="user-img">
                        <img src={{url('avatars/'.$fr->filename)}} alt="">
                        @if($fr->isOnline())
                            <span class="status f-online"></span>
                        @else
                            <span class="status f-offline"></span>
                        @endif
                    </figure>
                    <div class="friendz-meta">
                        <a href="time-line.html">{{$fr->name}}</a>
                        <a href="/cdn-cgi/l/email-protection" >{{$fr->email}}</a></i>
                    </div>
                </li>
                    @endif
                @endforeach
            </ul>
            <div class="chat-box">
                <div class="chat-head">
                    <span class="status f-online"></span>
                    <h6>Bucky Barnes</h6>
                    <div class="more">
                        <span><i class="ti-more-alt"></i></span>
                        <span class="close-mesage"><i class="ti-close"></i></span>
                    </div>
                </div>
                <div class="chat-list">
                    <ul>
                        <li class="me">
                            <div class="chat-thumb"><img src={{asset('images/resources/chatlist1.jpg')}} alt=""></div>
                            <div class="notification-event">
															<span class="chat-message-item">
																Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks
															</span>
                                <span class="notification-date"><time datetime="2004-07-24T18:18" class="entry-date updated">Yesterday at 8:10pm</time></span>
                            </div>
                        </li>
                        <li class="you">
                            <div class="chat-thumb"><img src={{asset('images/resources/chatlist2.jpg')}} alt=""></div>
                            <div class="notification-event">
															<span class="chat-message-item">
																Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks
															</span>
                                <span class="notification-date"><time datetime="2004-07-24T18:18" class="entry-date updated">Yesterday at 8:10pm</time></span>
                            </div>
                        </li>
                        <li class="me">
                            <div class="chat-thumb"><img src={{asset('images/resources/chatlist1.jpg')}} alt=""></div>
                            <div class="notification-event">
															<span class="chat-message-item">
																Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks
															</span>
                                <span class="notification-date"><time datetime="2004-07-24T18:18" class="entry-date updated">Yesterday at 8:10pm</time></span>
                            </div>
                        </li>
                    </ul>
                    <form class="text-box">
                        <textarea placeholder="Post enter to post..."></textarea>
                        <div class="add-smiles">
                            <span title="add icon" class="em em-expressionless"></span>
                        </div>
                        <div class="smiles-bunch">
                            <i class="em em---1"></i>
                            <i class="em em-smiley"></i>
                            <i class="em em-anguished"></i>
                            <i class="em em-laughing"></i>
                            <i class="em em-angry"></i>
                            <i class="em em-astonished"></i>
                            <i class="em em-blush"></i>
                            <i class="em em-disappointed"></i>
                            <i class="em em-worried"></i>
                            <i class="em em-kissing_heart"></i>
                            <i class="em em-rage"></i>
                            <i class="em em-stuck_out_tongue"></i>
                        </div>
                        <button type="submit"></button>
                    </form>
                </div>
            </div>
        </div><!-- friends list sidebar -->
    </aside>
</div><!-- sidebar -->
