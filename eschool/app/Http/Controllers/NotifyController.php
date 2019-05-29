<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shownotify()
    {
        $user = Auth::user();
        return view('notifications.notify');
    }

    public function notify(Request $request)
    {
        if($request->ajax())
        {
            $receiver = Auth::user();
            if($request->id > 0)
            {
                $data = DB::table('notifications')
                    ->where('id', '<', $request->id)
                    ->where('receiver_id','=',$receiver->id)
                    ->where('sender_id','!=',$receiver->id)
                    ->where('checked','=','0')
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('notifications')
                    ->where('receiver_id','=',$receiver->id)
                    ->where('sender_id','!=',$receiver->id)
                    ->where('checked','=','0')
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();


            }

            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $notify)
                {
                    $sender = DB::table('users')
                        ->where('id','=',$notify->sender_id)
                        ->first();
                    $car = new Carbon($notify->updated_at);
                    $dif = $car->diffForHumans();

                    if($notify->post_id != null)
                    {
                        $output .= '<li>
                                    <figure><img src="'.url('avatars/'.$sender->filename).'" alt=""></figure>
                                    <div class="notifi-meta">
                                        <p><a href="'.url('wall/'.$sender->id).'">'.$sender->name.'</a>
                                        <p>'.$notify->content.' By You!</p>
                                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <a href="'.url('post/show/'.$notify->post_id).'">Detail!</a>
                                        <br/>
                                        <span>'.$dif.'</span>
                                    </div>
                            
                                </li>';
                    }
                    elseif ($notify->result_id != null)
                    {
                        $tar = 'Did a test!';
                    }




                    $last_id = $notify->id;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showact()
    {
        return view('notifications.activity');
    }
    public function activity(Request $request)
    {
        if($request->ajax())
        {
            $sender = Auth::user();
            if($request->id > 0)
            {
                $data = DB::table('notifications')
                    ->where('id', '<', $request->id)
                    ->where('sender_id','=',$sender->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('notifications')
                    ->where('sender_id','=',$sender->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }

            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $notify)
                {
                    $car = new Carbon($notify->updated_at);
                    $dif = $car->diffForHumans();


                    if($notify->post_id != null)
                    {

                        $output .= '<li>
                                    <div class="notifi-meta">
                                        <p>You '.$notify->content.'</p>
                                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <a href="'.url('post/show/'.$notify->post_id).'">Detail!</a>
                                        <br/>
                                        <span>'.$dif.'</span>
                                       
                                    </div>
                            
                                </li>';
                    }
                    elseif ($notify->result_id != null)
                    {
                        $output .= '<li>
                                    <div class="notifi-meta">
                                        <p>You '.$notify->content.'</p>
                                        <span>'.$dif.'</span>
                                    </div>
                            
                                </li>';
                    }
                    $last_id = $notify->id;
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

}
