<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Subject;
use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;


// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

class EditProfileController extends Controller
{
    public function index()
    {
        if( Auth::check() ){
            $user = User::all();
            $currentuser = new User();
            foreach ($user as $u){
                if ($u->id == Auth::user()->id){
                    $currentuser = $u;
                }
            }
            $subject = Subject::all();
            $level = Level::all();
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

            return view('profiles.edit', compact('frs','notifications','not_count','activities','user','level','subject','currentuser','not_count'));
        }
        return view('auth.login');
    }
    public function store(Request $request)
    {

        $id = Auth::user()->id;

        $change_name = $request->get('user_name');
        $change_email = $request->get('user_email');
        $change_city = $request->get('user_city');
        $change_height = $request->get('height');
        $change_weight = $request->get('weight');
        $change_self = $request->get('desc');
        $change_dob = $request->get('dob');


        //check if user pass null data
        if ($change_name == null){
            $username = Auth::user()->name;
        }else{
            $username = $change_name;
        }
        if ($change_email == null){
            $email =Auth::user()->email;
        }else{
            $email =$change_email;
        }
        if ($change_city == null){
            $city =Auth::user()->city;
        }else{
            $city =$change_city;
        }
        if ($change_height == null){
            $height =Auth::user()->height;
        }else{
            $height =$change_height;
        }
        if ($change_weight == null){
            $weight =Auth::user()->weight;
        }else{
            $weight =$change_weight;
        }
        if ($change_self == null){
            $self =Auth::user()->self;
        }else{
            $self =$change_self;
        }
        if ($change_dob == null){
            $dob =Auth::user()->dob;
        }else{
            $dob =$change_dob;
        }


        //profile img
        if ($request->file('avatar') != NULL){

            $photo = $request->file('avatar');
//            $avatar = Image::make($photo->getRealPath())->resize(45,45)->save($photo.time().$photo->getClientOriginalName());

            $extension = $photo->getClientOriginalExtension();
            Storage::disk('public_avatars')->put($photo->getFilename() . '.' . $extension, File::get($photo));


            $mime = $photo->getClientMimeType();
            $original_filename = $photo->getClientOriginalName();
            $filename = $photo->getFilename() . '.' . $extension;


        }
        else{
            $mime=Auth::user()->mime;
            $original_filename=Auth::user()->original_filename;
            $filename=Auth::user()->filename;
        }
        $frs= User::all();

        //end check

        //update database
        DB::table('users')->where('id', $id) ->update(
            ['name'=>$username,'email'=>$email,'height'=>$height,'mime'=>$mime,'original_filename'=>$original_filename
                ,'filename'=>$filename,'weight'=>$weight, 'self' => $self, 'city'=>$city,'dob'=>$dob]
        );
        return back()->with('success','Profile updated !',[$frs]);
    }
}