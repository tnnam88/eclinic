<?php

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;


?>
<div class="responsive-header">
    <div class="mh-head first Sticky">
			<span class="mh-btns-left">
				<a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
			</span>
        <span class="mh-text">
				<i class="fa fa-graduation-cap fa-2x " id="logo-cap" aria-hidden="true"></i>

			</span>
        <span class="mh-btns-right">
				<a class="fa fa-sliders" href="#shoppingbag"></a>
			</span>
    </div>
    <div class="mh-head second">
        <form class="mh-form">
            <input placeholder="search" />
            <a href="#/"><i class="fa fa-search fa-2x"></i></a>
        </form>
    </div>
    <nav id="menu" class="res-menu">
        <ul>
            <li><span>Home</span>
            </li>
            <li><span>Do Test</span>
            </li>
            <li><span>Profile</span>
                <ul>
                    <li><a href="{{url('profiles.show')}}" title="">show profile</a></li>
                    <li><a href="{{url('profiles.edit')}}" title="">edit profile basics</a></li>
                </ul>
            </li>
            <li><span>Support & Help</span>
                <ul>
                    <li><a href="support-and-help.html" title="">Support & Help</a></li>
                    <li><a href="support-and-help-detail.html" title="">Support & Help Detail</a></li>
                    <li><a href="support-and-help-search-result.html" title="">Support & Help Search Result</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <nav id="shoppingbag">
        <div>
            <div class="">
                <form method="post">
                    <div class="setting-row">
                        <span>use night mode</span>
                        <input type="checkbox" id="nightmode"/>
                        <label for="nightmode" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Notifications</span>
                        <input type="checkbox" id="switch2"/>
                        <label for="switch2" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Notification sound</span>
                        <input type="checkbox" id="switch3"/>
                        <label for="switch3" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>My profile</span>
                        <input type="checkbox" id="switch4"/>
                        <label for="switch4" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Show profile</span>
                        <input type="checkbox" id="switch5"/>
                        <label for="switch5" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                </form>
                <h4 class="panel-title">Account Setting</h4>
                <form method="post">
                    <div class="setting-row">
                        <span>Sub users</span>
                        <input type="checkbox" id="switch6" />
                        <label for="switch6" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>personal account</span>
                        <input type="checkbox" id="switch7" />
                        <label for="switch7" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Business account</span>
                        <input type="checkbox" id="switch8" />
                        <label for="switch8" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Show me online</span>
                        <input type="checkbox" id="switch9" />
                        <label for="switch9" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Delete history</span>
                        <input type="checkbox" id="switch10" />
                        <label for="switch10" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Expose author name</span>
                        <input type="checkbox" id="switch11" />
                        <label for="switch11" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</div><!-- responsive header -->

<div class="topbar stick">
    <div class="logo">
        {{--<a title="" href={{url('/')}}><i class="fa fa-graduation-cap fa-5x" aria-hidden="true"></i>--}}
        {{--</a>--}}
        <a href=""><img src="{{asset('images/logo.png')}}"></a>
    </div>
    <div class ="search-eshool">
            <input type="text" placeholder="Search.." name="search">
            <i class="fa fa-search fa-2x"></i>

    </div>

    <div class="top-area">
        {{--<ul class="main-menu">--}}
            {{--<li>--}}
                {{--<a href="#" title="">Home</a>--}}
                {{--<ul>--}}
                    {{--<li><a href="index.html" title="">Home Social</a></li>--}}
                    {{--<li><a href="index2.html" title="">Home Social 2</a></li>--}}
                    {{--<li><a href="index-company.html" title="">Home Company</a></li>--}}
                    {{--<li><a href="landing.html" title="">Login page</a></li>--}}
                    {{--<li><a href="logout.html" title="">Logout Page</a></li>--}}
                    {{--<li><a href="newsfeed.html" title="">news feed</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="#" title="">timeline</a>--}}
                {{--<ul>--}}
                    {{--<li><a href="time-line.html" title="">timeline</a></li>--}}
                    {{--<li><a href="timeline-friends.html" title="">timeline friends</a></li>--}}
                    {{--<li><a href="timeline-groups.html" title="">timeline groups</a></li>--}}
                    {{--<li><a href="timeline-pages.html" title="">timeline pages</a></li>--}}
                    {{--<li><a href="timeline-photos.html" title="">timeline photos</a></li>--}}
                    {{--<li><a href="timeline-videos.html" title="">timeline videos</a></li>--}}
                    {{--<li><a href="fav-page.html" title="">favourit page</a></li>--}}
                    {{--<li><a href="groups.html" title="">groups page</a></li>--}}
                    {{--<li><a href="page-likers.html" title="">Likes page</a></li>--}}
                    {{--<li><a href="people-nearby.html" title="">people nearby</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="#" title="">account settings</a>--}}
                {{--<ul>--}}
                    {{--<li><a href="create-fav-page.html" title="">create fav page</a></li>--}}
                    {{--<li><a href="edit-account-setting.html" title="">edit account setting</a></li>--}}
                    {{--<li><a href="edit-interest.html" title="">edit-interest</a></li>--}}
                    {{--<li><a href="edit-password.html" title="">edit-password</a></li>--}}
                    {{--<li><a href="{{url('editprofile')}}" title="">edit profile basics</a></li>--}}
                    {{--<li><a href="edit-work-eductation.html" title="">edit work educations</a></li>--}}
                    {{--<li><a href="messages.html" title="">message box</a></li>--}}
                    {{--<li><a href="inbox.html" title="">Inbox</a></li>--}}
                    {{--<li><a href="notifications.html" title="">notifications page</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="#" title="">more pages</a>--}}
                {{--<ul>--}}
                    {{--<li><a href="404.html" title="">404 error page</a></li>--}}
                    {{--<li><a href="about.html" title="">about</a></li>--}}
                    {{--<li><a href="contact.html" title="">contact</a></li>--}}
                    {{--<li><a href="faq.html" title="">faq's page</a></li>--}}
                    {{--<li><a href="insights.html" title="">insights</a></li>--}}
                    {{--<li><a href="knowledge-base.html" title="">knowledge base</a></li>--}}
                    {{--<li><a href="widgets.html" title="">Widgts</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        {{--</ul>--}}

        <ul class="setting-area menu-icon-eshool">
            <li>

            </li>
            <li>
                <a href="#" title="Notification" data-ripple="">
                    <i class="fa fa-bell-o fa-2x" aria-hidden="true"></i>
                    <span>{{$not_count}}</span>
                </a>
                <div class="dropdowns">
                    <span>{{$not_count}} New Notifications</span>
                    <ul class="drops-menu">
                        @foreach($notifications as $notify)
                            @php
                                $sender = DB::table('users')
                                    ->where('id','=',$notify->sender_id)
                                    ->first();
                                $car = new Carbon($notify->updated_at);
                                $dif = $car->diffForHumans();

                            @endphp
                            <li>
                                <a href="{{url('notify')}}" title="">
                                    <img src={{url('avatars/'.$sender->filename)}} alt="">
                                    <div class="mesg-meta">
                                        <h6>{{$sender->name}}</h6>
                                        <span>{{$notify->content}}</span>
                                        <i>{{$dif}}</i>
                                    </div>
                                </a>
                                <span class="tag green">New</span>
                            </li>
                        @endforeach
                        {{--<li>--}}
                            {{--<a href="notifications.html" title="">--}}
                                {{--<img src={{asset('images/resources/thumb-1.jpg')}} alt="">--}}
                                {{--<div class="mesg-meta">--}}
                                    {{--<h6>sarah Loren</h6>--}}
                                    {{--<span>Hi, how r u dear ...?</span>--}}
                                    {{--<i>2 min ago</i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<span class="tag green">New</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="notifications.html" title="">--}}
                                {{--<img src={{asset('images/resources/thumb-2.jpg')}} alt="">--}}
                                {{--<div class="mesg-meta">--}}
                                    {{--<h6>Jhon doe</h6>--}}
                                    {{--<span>Hi, how r u dear ...?</span>--}}
                                    {{--<i>2 min ago</i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<span class="tag red">Reply</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="notifications.html" title="">--}}
                                {{--<img src={{asset('images/resources/thumb-3.jpg')}} alt="">--}}
                                {{--<div class="mesg-meta">--}}
                                    {{--<h6>Andrew</h6>--}}
                                    {{--<span>Hi, how r u dear ...?</span>--}}
                                    {{--<i>2 min ago</i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<span class="tag blue">Unseen</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="notifications.html" title="">--}}
                                {{--<img src={{asset('images/resources/thumb-4.jpg')}} alt="">--}}
                                {{--<div class="mesg-meta">--}}
                                    {{--<h6>Tom cruse</h6>--}}
                                    {{--<span>Hi, how r u dear ...?</span>--}}
                                    {{--<i>2 min ago</i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<span class="tag">New</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="notifications.html" title="">--}}
                                {{--<img src={{asset('images/resources/thumb-5.jpg')}} alt="">--}}
                                {{--<div class="mesg-meta">--}}
                                    {{--<h6>Amy</h6>--}}
                                    {{--<span>Hi, how r u dear ...?</span>--}}
                                    {{--<i>2 min ago</i>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                            {{--<span class="tag">New</span>--}}
                        {{--</li>--}}
                    </ul>
                    <a href="{{ route('notify') }}"
                       class="more-mesg"
                       onclick="event.preventDefault();
                   document.getElementById('notifications').submit();">
                        <i class="ti-bell"></i>
                        {{ __('View more') }}
                    </a>
                    <form id="notifications" action="{{ route('notifications') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </li>

            <li><a href="#" title="Languages" data-ripple=""><i class="fa fa-globe fa-2x"></i></a>
                <div class="dropdowns languages">
                    <a href="#" title=""><i class="ti-check"></i>English</a>
                    <a href="#" title="">Arabic</a>
                    <a href="#" title="">Dutch</a>
                    <a href="#" title="">French</a>
                </div>
            </li>
        </ul>
        <div class="user-img">
            <?php
            $avatar = Auth::user()->filename;

            ?>
            <img src="{{url('avatars/'.$avatar)}}" alt="{{$avatar}}">
            <span class="status f-online"></span>
            <div class="user-setting">
                <a href="#" title=""><span class="status f-online"></span>online</a>
                <a href="#" title=""><span class="status f-away"></span>away</a>
                <a href="#" title=""><span class="status f-off"></span>offline</a>

                <a href="#" onclick="event.preventDefault();
                   document.getElementById('show_profile').submit();">
                    <i class="ti-user"></i> show profile</a>
                <form id="show_profile" action="/showprofile" method="get" style="display: none;">
                    @csrf
                </form>

                <a href="#" onclick="event.preventDefault();
                   document.getElementById('edit_profile').submit();" >
                    <i class="ti-pencil-alt"></i>edit profile</a>
                <form id="edit_profile" action="/editprofile" method="get" style="display: none;">
                    @csrf
                </form>

                <a href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    <i class="ti-power-off"></i>
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </div>
        <span class="ti-menu main-menu" data-ripple=""></span>
    </div>
</div><!-- topbar -->
