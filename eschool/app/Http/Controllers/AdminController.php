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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Notification;

class AdminController extends Controller
{
    public function showacc(Request $request)
    {
        if($request->ajax())
        {
            if($request->id > 0)
            {
                $data = DB::table('users')
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            else
            {
                $data = DB::table('users')
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }
            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $acc)
                {
                    $admin =  Auth::user();
                    $car = new Carbon($acc->updated_at);
                    $dif = $car->diffForHumans();
                    $subject ='none';
                    $level = 'none';




                    $output .= '<div class="central-meta item tr" id="post-cube-'.$acc->id.'">
                    <div class="user-post tr">
                        <div class="friend-info ">
                            <figure class="post-avatar wid-10">
                                <img src="'.url('avatars/'.$acc->filename).'" alt="">
                            </figure>
                            <div class="friend-name wid-50">
                                <ins><a href="'.url('wall/'.$acc->id).'" title="">'.$acc->name.'</a></ins>
                                <a href="" class="lead">'.$acc->role.'</a>
                                <span>'.$dif.'</span>
                
                            </div>
                            <div class="wid-15">
                                <p>#Subject-'.$subject.'</p>
                                
                            </div>
                            <div class="wid-15">
                                <p>#Level-'.$level.'</p>
                              
                            </div>
                            
                            <div class="wid-10">
                            <button id="post-' . $acc->id . '" class="del-post" data-post = "' . $acc->id . '">
                            <i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                            </div>
                            </div>
                        
                        
                    </div>
                </div>';
                    $last_id = $acc->id;
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

    public  function delacc(Request $request)
    {
        if($request->ajax())
        {
            $check = DB::table('users')
                ->where('id','=',$request->acc_id)
                ->exists();
            if($check)
            {
                $name = DB::table('users')
                    ->where('id','=',$request->acc_id)
                    ->first()->name;

                DB::table('posts')
                    ->where('user_id','=',$request->acc_id)
                    ->delete();
                DB::table('comments')
                    ->where('user_id','=',$request->acc_id)
                    ->delete();
                DB::table('likes')
                    ->where('user_id','=',$request->acc_id)
                    ->delete();
                DB::table('results')
                    ->where('user_id','=',$request->acc_id)
                    ->delete();
                DB::table('notifications')
                    ->where('receiver_id','=',$request->acc_id)
                    ->delete();
                DB::table('notifications')
                    ->where('sender_id','=',$request->acc_id)
                    ->delete();
                DB::table('users')
                    ->where('id','=',$request->acc_id)
                    ->delete();
                //notification for a del user
                $notify = new Notification;
                $notify->sender_id = Auth::user()->id;
                $notify->content = 'You Remove a User:'.$name;
                $notify->save();
                echo '';
            }

        }
    }

    public function adm_register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect()->back()->with('alert', 'Updated!');

    }
}
