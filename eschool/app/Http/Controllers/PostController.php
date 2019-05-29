<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Post;
use App\Like;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Notification;


class PostController extends Controller
{
    /**
     * Link to Home Page
     *
     *
     * @return welcome
     */
    function index()
    {

        return view('welcome');
    }
    /**
     * Control ajax  load more post on Home Page
     * return post data through echo not view
     *
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $frs= User::all();
        $this->validate(request(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = \Auth::user()->id;



        // Store photo of a post
        if ($request->file('photo') != NULL) {
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension();
            Storage::disk('public')->put($photo->getFilename() . '.' . $extension, File::get($photo));


            $post->mime = $photo->getClientMimeType();
            $post->original_filename = $photo->getClientOriginalName();
            $post->filename = $photo->getFilename() . '.' . $extension;
        }
        $post->save();
        //notification for a new post
        $notify = new Notification;
        $notify->sender_id = Auth::user()->id;
        $notify->post_id = $post->id;
        $notify->content = 'Create a New Post ';
        $notify->save();


        return back()->with('success', 'Post has been added',[$frs]);
    }
    function loadpost(Request $request)
    {
        if($request->ajax())
        {
            if($request->id > 0)
            {
                $data = DB::table('posts')
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('posts')
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }
            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $post)
                {
                    $user = Auth::user();
                    $user_avt =$user->filename;
                    $post_user = DB::table('users')
                        ->where('id', $post->user_id)
                        ->first();
                    $count_cm =  DB::table('comments')
                        ->where('post_id','=',$post->id)
                        ->count();
                    $comments =  DB::table('comments')
                        ->where('post_id','=',$post->id)
                        ->limit(3)
                        ->get();
                    $avatar=$post_user->filename;
                    $car = new Carbon($post->updated_at);
                    $dif = $car->diffForHumans();



                    $output .= '<div class="central-meta item" id="post-cube-'.$post->id.'">
                    <div class="user-post">
                        <div class="friend-info">
                            <figure class="post-avatar">
                                <img src="'.url('avatars/'.$avatar).'" alt="">
                            </figure>
                            <div class="friend-name wid-80">
                                <ins><a href="'.url('wall/'.$post_user->id).'" title="">'.$post_user->name.'</a></ins>
                                <a href="'.url('post/show/'.$post->id).'" class="lead post-title-custom">'.$post->title.'</a>
                                <span>'.$dif.'</span>
                
                            </div>';
                    if($user->role == 'teacher'||$user->role == 'admin'||$user->id ==$post->user_id) {
                        $output .='<div class="wid-10">
                            <button id="post-' . $post->id . '" class="del-post" data-post = "' . $post->id . '">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>';
                    }

                    $output .= '<div class="post-meta">
                                <img src="uploads/'.$post->filename.'" alt="">
                
                                <div class="we-video-info">
                                    <ul>
                
                                        <li>
                                               <span class="comment" data-toggle="tooltip" title="Comments">
                                                   <i class="fa fa-comments-o"></i>
                                                   <ins>'.$count_cm.'</ins>
                                               </span>
                                        </li>
                
                
                                        <li class="social-media">
                                            <div class="menu">
                                                <div class="btn trigger"><i class="fa fa-share-alt"></i></div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-html5"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-facebook"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-google-plus"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-twitter"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-css3"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-instagram"></i></a>
                                                    </div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-dribbble"></i></a>
                                                    </div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-pinterest"></i></a>
                                                    </div>
                                                </div>
                
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                
                                <div class="description">
                
                                    <p>
                                        '.$post->content.'
                                    </p>
                                </div>
                            </div>
                
                        </div>
                        
                        <div class="coment-area" >
                            
                            <ul class="we-comet'.$post->id.' we-comet" id="post-cmt'.$post->id.'" data-cmt="'.$post->id.'">
                                
                                <li class="post-comment">
                                    <div class="comet-avatar">
                                        <img src="'.url('avatars/'.$user_avt).'" alt="{{$avatar}}">
                                    </div>
                                    <div class="post-comt-box">
                                                <input type="hidden" name="_token" value='.csrf_token().'>
                                            <textarea  id="addcmt'.$post->id.'" placeholder="Post your comment" required="required"  name="content"></textarea>        
                                            <button data-p="'.$post->id.'" type="submit" class="new-cmt">Comment</button>                                        
                                    </div>
                                </li>
                                <li>
                                    <button type="button" name="l" class="btn btn-success load_more_cmt" 
                                    id="load_more_cmt'.$post->id.'" data-newid="0"
                                    data-id="0" data-post="'.$post->id.'">Load Old Comment</button>
                                </li>
          
                                
                            </ul>
                            
                        </div>
                    </div>
                </div>';
                                    $last_id = $post->id;
                }
                                $output .= '
                       <div id="load_more">
                        <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                       </div>
                       ';
            }
            else
            {
                $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
       </div>
       ';
            }

            echo $output;


        }
    }

    /**
     * Control ajax  load more comment on Home Page, Wall
     * return comment data through echo not view
     *
     */
    function loadcomment(Request $request)
    {
        if($request->ajax())
        {
            $user = Auth::user();
            if($request->id > 0)
            {
                $comments = DB::table('comments')
                    ->where('post_id',$request->post_id)
                    ->where('id','<',$request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }
            else
            {
                $comments = DB::table('comments')
                    ->where('post_id',$request->post_id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();


            }
            $output = '';
            $last_id = '';

            if(!$comments->isEmpty())
            {
                foreach($comments as $cmt) {
                    $cmt_user = DB::table('users')
                        ->where('id', $cmt->user_id)
                        ->first();
                    $avatar=$cmt_user->filename;
                    $car = new Carbon($cmt->updated_at);
                    $dif = $car->diffForHumans();
                    $like_count= DB::table('likes')
                        ->where('comment_id','=',$cmt->id)
                        ->count();
                    $check_like=DB::table('likes')
                        ->where('user_id','=',$cmt_user->id)
                        ->where('comment_id','=',$cmt->id)
                        ->exists();
                    if($check_like)
                    {
                        $like_box ='
                            
                    <ins>'.$like_count.'</ins>
                    <i  class="fa fa-thumbs-up we-reply" title=""></i>
                    
                    <button class="changelike" title=""
                    id="like'.$cmt->id.'"
                    data-like_user="'.$cmt_user->id.'" data-like_cmt="'.$cmt->id.'" type="button">
                    Liked!
                    </button>
                        ';
                    }
                    else{
                        $like_box ='
                            
                    <ins>'.$like_count.'</ins>
                    <i  class="fa fa-thumbs-o-up we-reply" title=""></i>
                    
                    <button class="changelike" title=""
                    id="like'.$cmt->id.'"
                    data-like_user="'.$cmt_user->id.'" data-like_cmt="'.$cmt->id.'" type="button">
                    Like this comment!
                    </button>
                        ';
                    }
                    if($user->role == 'teacher'||$user->role == 'admin'||$user->id ==$cmt->user_id) {
                        $like_box .= '<div class="wid-10">
                            <button id="post-' . $cmt->id . '" class="del-cmt" data-cmt = "' . $cmt->id . '"
                            title="remove this comment!">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>';
                    }


                    $output .= '
                        <li data-cmt="'.$cmt->id.'" id="del-cmt'.$cmt->id.'">
                            <div class="comet-avatar">
                                <img src="'.url('avatars/'.$avatar).'" alt="">

                            </div>
                            <div class="we-comment wid-50">
                                <div class="coment-head" >
                                    <h5><a href="'.url('wall/'.$cmt_user->id).'" title="">'.$cmt_user->name.'</a></h5>
                                    <span>'.$dif.'</span>  
                                </div>
                                <p> '.$cmt->content.'
                                    <i class="em em-smiley"></i>
                                </p>
                                <input type="hidden" name="_token" value='.csrf_token().'>
                                <div id="changelike'.$cmt->id.'">
                                    '.$like_box.'
                                </div>
                            </div>
                            </li>';
                    $last_id = $cmt->id;
                }
                $output .= '
                       <button type="button" name="l" class="btn btn-success  load_more_cmt" 
                                    id="load_more_cmt'.$request->post_id.'" 
                                    data-id="'.$last_id.'" data-post="'.$request->post_id.'">Load More Comment</button>
                       ';
            }
            else
            {

                $output .= '
       <div id="load_more">
        <button type="button" name="l" class="btn btn-info "
        id="load_more_cmt'.$request->post_id.'"  
         >No More Found</button>
       </div>
       ';
            }

            echo $output;


        }
    }

    function postcmt(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $last_id="";
            $user = Auth::user();
            $post_id = $request->post_id;
            $top_cmt = $request->top_cmt;
            $content = $request->content;

            $comment = new Comment;
            $comment->content = $content;
            $comment->user_id = $user->id;
            $comment->post_id = $post_id;
            $comment->like_count = 0;
            $comment->save();

            $receiver = DB::table('posts')
                ->where('id','=',$post_id)
                ->first()->user_id;
            $notify = new Notification;
            $notify->sender_id = $user->id;
            $notify->receiver_id = $receiver;
            $notify->post_id = $post_id;
            $notify->content = 'Commented on a Post';
            $notify->save();
            if($top_cmt != null)
            {

                $comments = DB::table('comments')
                    ->where('post_id','=',$post_id)
                    ->where('id','>',$top_cmt)
                    ->orderBy('id','DESC')
                    ->get();
                if(!$comments->isEmpty())
                {
                    foreach($comments as $cmt) {
                        $cmt_user = DB::table('users')
                            ->where('id', $cmt->user_id)
                            ->first();
                        $avatar=$cmt_user->filename;
                        $car = new Carbon($cmt->updated_at);
                        $dif = $car->diffForHumans();
                        $like_count= DB::table('likes')
                            ->where('comment_id','=',$cmt->id)
                            ->count();
                        $check_like=DB::table('likes')
                            ->where('user_id','=',$cmt_user->id)
                            ->where('comment_id','=',$cmt->id)
                            ->exists();
                        if($check_like)
                        {
                            $like_box ='
                            
                    <ins>'.$like_count.'</ins>
                    <i  class="fa fa-thumbs-up we-reply" title=""></i>
                    
                    <button class="changelike" title=""
                    id="like'.$cmt->id.'"
                    data-like_user="'.$cmt_user->id.'" data-like_cmt="'.$cmt->id.'" type="button">
                    Liked!
                    </button>
                        ';
                        }
                        else{
                            $like_box ='
                            
                    <ins>'.$like_count.'</ins>
                    <i  class="fa fa-thumbs-o-up we-reply" title=""></i>
                    
                    <button class="changelike" title=""
                    id="like'.$cmt->id.'"
                    data-like_user="'.$cmt_user->id.'" data-like_cmt="'.$cmt->id.'" type="button">
                    Like this comment!
                    </button>
                        ';
                        }
                        if($user->role == 'teacher'||$user->role == 'admin'||$user->id ==$cmt->user_id) {
                            $like_box .= '<div class="wid-10">
                            <button id="post-' . $cmt->id . '" class="del-cmt" data-cmt = "' . $cmt->id . '"
                            title="remove this comment!">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>';
                        }


                        $output .= '
                        <li data-cmt="'.$cmt->id.'" id="del-cmt'.$cmt->id.'">
                            <div class="comet-avatar">
                                <img src="'.url('avatars/'.$avatar).'" alt="">

                            </div>
                            <div class="we-comment">
                                <div class="coment-head" >
                                    <h5><a href="'.url('wall/'.$cmt_user->id).'" title="">'.$cmt_user->name.'</a></h5>
                                    <span>'.$dif.'</span>  
                                </div>
                                <p> '.$cmt->content.'
                                    <i class="em em-smiley"></i>
                                </p>
                                <input type="hidden" name="_token" value='.csrf_token().'>
                                <div id="changelike'.$cmt->id.'">
                                    '.$like_box.'
                                </div>
                            </div>
                            
                        </li>';
                    }
                    echo $output;
                }
            }
            else
            {
                $comments = DB::table('comments')
                    ->where('post_id','=',$post_id)
                    ->orderBy('id','DESC')
                    ->limit(3)
                    ->get();

                foreach($comments as $cmt) {
                    $cmt_user = DB::table('users')
                        ->where('id', $cmt->user_id)
                        ->first();
                    $avatar = $cmt_user->filename;
                    $car = new Carbon($cmt->updated_at);
                    $dif = $car->diffForHumans();
                    $like_count= DB::table('likes')
                        ->where('comment_id','=',$cmt->id)
                        ->count();
                    $check_like=DB::table('likes')
                        ->where('user_id','=',$cmt_user->id)
                        ->where('comment_id','=',$cmt->id)
                        ->exists();
                    if($check_like)
                    {
                        $like_box ='
                            
                    <ins>'.$like_count.'</ins>
                    <i  class="fa fa-thumbs-up we-reply" title=""></i>
                    
                    <button class="changelike" title=""
                    id="like'.$cmt->id.'"
                    data-like_user="'.$cmt_user->id.'" data-like_cmt="'.$cmt->id.'" type="button">
                    Liked!
                    </button>
                        ';
                    }
                    else{
                        $like_box ='
                            
                    <ins>'.$like_count.'</ins>
                    <i  class="fa fa-thumbs-o-up we-reply" title=""></i>
                    
                    <button class="changelike" title=""
                    id="like'.$cmt->id.'"
                    data-like_user="'.$cmt_user->id.'" data-like_cmt="'.$cmt->id.'" type="button">
                    Like this comment!
                    </button>
                        ';
                    }
                    if($user->role == 'teacher'||$user->role == 'admin'||$user->id ==$cmt->user_id) {
                        $like_box .= '<div class="wid-10">
                            <button id="post-' . $cmt->id . '" class="del-cmt" data-cmt = "' . $cmt->id . '"
                            title="remove this comment!">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>';
                    }


                    $output .= '
                        <li data-cmt="'.$cmt->id.'" id="del-cmt'.$cmt->id.'">
                            <div class="comet-avatar">
                                <img src="'.url('avatars/'.$avatar).'" alt="">

                            </div>
                            <div class="we-comment">
                                <div class="coment-head" >
                                    <h5><a href="'.url('wall/'.$cmt_user->id).'" title="">'.$cmt_user->name.'</a></h5>
                                    <span>'.$dif.'</span>  
                                </div>
                                <p> '.$cmt->content.'
                                    <i class="em em-smiley"></i>
                                </p>
                                <input type="hidden" name="_token" value='.csrf_token().'>
                                <div id="changelike'.$cmt->id.'">
                                    '.$like_box.'
                                </div>
                            </div>
                            
                        </li>';
                    $last_id = $cmt->id;
                }
                $output .= '
                       <button type="button" name="l" class="btn btn-success  load_more_cmt" 
                                    id="load_more_cmt'.$request->post_id.'" 
                                    data-id="'.$last_id.'" data-post="'.$request->post_id.'">Load More Old Comments</button>
                       ';
                echo $output;

            }


        }
    }

    /**
     * Control ajax  load more post on Wall Page
     * return comment data through echo not view
     *
     */
    function wall($id)
    {
        $wall_id= $id;
        return view('wall', compact('wall_id'));
    }
    function  wallpost(Request $request)
    {
        if($request->ajax())
        {
            if($request->id > 0)
            {
                $data = DB::table('posts')
                    ->where('user_id','=',$request->wall_user_id)
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('posts')
                    ->where('user_id','=',$request->wall_user_id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }
            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $post)
                {
                    $user = Auth::user();
                    $post_user = DB::table('users')
                        ->where('id', $post->user_id)
                        ->first();
                    $count_cm =  DB::table('comments')
                        ->where('post_id','=',$post->id)
                        ->count();
                    $comments =  DB::table('comments')
                        ->where('post_id','=',$post->id)
                        ->limit(3)
                        ->get();
                    $avatar=$post_user->filename;
                    $car = new Carbon($post->updated_at);
                    $dif = $car->diffForHumans();



                    $output .= '<div class="central-meta item" id="post-cube-'.$post->id.'">
                    <div class="user-post">
                        <div class="friend-info">
                            <figure class="post-avatar">
                                <img src="'.url('avatars/'.$avatar).'" alt="">
                            </figure>
                            <p class="friend-name wid-80">
                                <ins><a href="'.url('wall/'.$post_user->id).'" title="">'.$post_user->name.'</a></ins>
                                <a  href="'.url('post/show/'.$post->id).'" class="lead post-title-custom">'.$post->title.'</a>
                                <span>'.$dif.'</span>
                
                            </div>';
                    if($user->role == 'teacher'||$user->role == 'admin'||$user->id ==$post->user_id) {
                        $output .='<div class="wid-10">
                            <button id="post-' . $post->id . '" class="del-post" data-post = "' . $post->id . '">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>';
                    }

                    $output .= '<div class="post-meta">
                                <img src="uploads/'.$post->filename.'" alt="">
                
                                <div class="we-video-info">
                                    <ul>
                
                                        <li>
                                               <span class="comment" data-toggle="tooltip" title="Comments">
                                                   <i class="fa fa-comments-o"></i>
                                                   <ins>'.$count_cm.'</ins>
                                               </span>
                                        </li>
                
                
                                        <li class="social-media">
                                            <div class="menu">
                                                <div class="btn trigger"><i class="fa fa-share-alt"></i></div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-html5"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-facebook"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-google-plus"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-twitter"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-css3"></i></a></div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-instagram"></i></a>
                                                    </div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-dribbble"></i></a>
                                                    </div>
                                                </div>
                                                <div class="rotater">
                                                    <div class="btn btn-icon"><a href="#" title=""><i class="fa fa-pinterest"></i></a>
                                                    </div>
                                                </div>
                
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                
                                <div class="description">
                
                                    <p>
                                        '.$post->content.'
                                    </p>
                                </div>
                            </div>
                
                        </div>
                        
                        <div class="coment-area" >
                            
                            <ul class="we-comet'.$post->id.' we-comet" id="post-cmt'.$post->id.'" data-cmt="'.$post->id.'">
                                
                                <li class="post-comment">
                                    <div class="comet-avatar">
                                        <img src="'.url('avatars/'.$user->filename).'" alt="{{$avatar}}">
                                    </div>
                                    <div class="post-comt-box">
                                                <input type="hidden" name="_token" value='.csrf_token().'>
                                            <textarea  id="addcmt'.$post->id.'" placeholder="Post your comment" required="required"  name="content"></textarea>        
                                            <button data-p="'.$post->id.'" type="submit" class="new-cmt">Comment</button>                                        
                                    </div>
                                </li>
                                <li>
                                    <button type="button" name="l" class="btn btn-success load_more_cmt" 
                                    id="load_more_cmt'.$post->id.'" data-newid="0"
                                    data-id="0" data-post="'.$post->id.'">Load Old Comment</button>
                                </li>
          
                                
                            </ul>
                            
                        </div>
                    </div>
                </div>';
                    $last_id = $post->id;
                }
                $output .= '
                       <div id="load_more">
                        <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                       </div>
                       ';
            }
            else
            {
                $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
       </div>
       ';
            }

            echo $output;


        }
    }

    function  showpost($id)
    {


        return view('posts.show', compact('id'));
    }


    public function manager()
    {
        $levels =DB::table('levels')->get();
        $subjects =DB::table('subjects')->get();
        return view('posts.allpost',compact('levels','subjects'));
    }
    public function allpost(Request $request)
    {
        if($request->ajax())
        {
            if($request->id > 0)
            {
                $data = DB::table('posts')
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('posts')
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }
            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $post)
                {
                    $user =  Auth::user();
                    $post_user = DB::table('users')
                        ->where('id', $post->user_id)
                        ->first();
                    $count_cm =  DB::table('comments')
                        ->where('post_id','=',$post->id)
                        ->count();
                    $comments =  DB::table('comments')
                        ->where('post_id','=',$post->id)
                        ->limit(3)
                        ->get();
                    $avatar=$post_user->filename;
                    $car = new Carbon($post->updated_at);
                    $dif = $car->diffForHumans();
                    $subject ='none';
                    $level = 'none';




                    $output .= '<div class="central-meta item tr" id="post-cube-'.$post->id.'">
                    <div class="user-post tr">
                        <div class="friend-info ">
                            <figure class="post-avatar wid-10">
                                <img src="'.url('avatars/'.$avatar).'" alt="">
                            </figure>
                            <div class="friend-name wid-50">
                                <ins><a href="'.url('wall/'.$post_user->id).'" title="">'.$post_user->name.'</a></ins>
                                <a href="'.url('post/show/'.$post->id).'" class="lead post-title-custom">'.$post->title.'</a>
                                <span>'.$dif.'</span>
                
                            </div>
                            <div class="wid-15">
                                <p>#Subject-'.$subject.'</p>
                                
                            </div>
                            <div class="wid-15">
                                <p>#Level-'.$level.'</p>
                              
                            </div>';
                        if($user->role == 'teacher'||$user->role == 'admin'||$user->id ==$post->user_id) {
                            $output .='<div class="wid-10">
                            <button id="post-' . $post->id . '" class="del-post" data-post = "' . $post->id . '">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>';
                            }
                            $output .='</div>
                        
                        
                    </div>
                </div>';
                    $last_id = $post->id;
                }
                $output .= '
                       <div id="load_more">
                        <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                       </div>
                       ';
            }
            else
            {
                $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
       </div>
       ';
            }

            echo $output;


        }
    }
    function delpost(Request $request)
{
    if($request->ajax())
    {
        $poster_id = DB::table('posts')
            ->where('id','=',$request->post_id)
            ->first()->user_id;
        DB::table('posts')
            ->where('id','=',$request->post_id)
            ->delete();
        //notification for a del post
        $notify = new Notification;
        $notify->sender_id = Auth::user()->id;
        $notify->receiver_id = $poster_id;
        $notify->post_id = $request->post_id;
        $notify->content = 'A Post Has Been Del ';
        $notify->save();
        echo '';
    }
}
    function delcmt(Request $request)
    {
        if($request->ajax())
        {
            $cmter_id = DB::table('comments')
                ->where('id','=',$request->cmt_id)
                ->first()->user_id;
            DB::table('comments')
                ->where('id','=',$request->cmt_id)
                ->delete();
            //notification for a del post
            $notify = new Notification;
            $notify->sender_id = Auth::user()->id;
            $notify->receiver_id = $cmter_id;
            $notify->comment_id = $request->cmt_id;
            $notify->content = 'A Comment Has Been Del ';
            $notify->save();
            echo '';
        }
    }


}
