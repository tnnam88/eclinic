<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Result;
use App\User;


class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testform()
    {

        $levels = DB::table('levels')->get();
        $subjects = DB::table('subjects')->get();
        return view('tests.testform', compact('levels','subjects'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        $level_id = $request->input('testlvl_id');
        $subject_id = $request->input('testsubject_id');
        $questions = DB::table('questions')
            ->where('level_id',$level_id)
            ->where('subject_id',$subject_id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('tests.test', compact('levels','subjects','questions','level_id','subject_id'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new question.
     *
     * @return \Illuminate\Http\Response
     */
    public function addQuestionForm()
    {
        $levels = DB::table('levels')->get();
        $subjects = DB::table('subjects')->get();

        return view('tests.addQuestionForm', compact('user','levels','subjects'));


    }

    /**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {

    }

    /**
     * Store a newly created question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addQuestion(Request $request)
    {
        $user_id = Auth::user()->id;
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

        $level_id = $request->input('testlvl_id');
        $subject_id = $request->input('testsubject_id');
        $question = $request->input('question');
        $answer1 = $request->input('answer1');
        $answer2 = $request->input('answer2');
        $answer3 = $request->input('answer3');
        $answer = $request->input('answer');

        $question_id = DB::table('questions')->insertGetId(
            ['user_id'=>$user_id,'subject_id' => $subject_id, 'level_id' => $level_id, 'content' => $question]
        );
        DB::table('answers')->insert(
            ['question_id' => $question_id, 'content' => $answer1, 'is_correct' => 0]
        );
        DB::table('answers')->insert(
            ['question_id' => $question_id, 'content' => $answer2, 'is_correct' => 0]
        );
        DB::table('answers')->insert(
            ['question_id' => $question_id, 'content' => $answer3, 'is_correct' => 0]
        );
        DB::table('answers')->insert(
            ['question_id' => $question_id, 'content' => $answer, 'is_correct' => 1]
        );
        return view('tests.addQuestionResult', compact('frs','notifications','not_count','activities','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        $level_id = $request->input('level_id');
        $subject_id = $request->input('subject_id');
        $time = $request->input('time');
        $user_id = Auth::id();
        $results = $request->all();
        $p = 0;
        if(count($results) == 3){
            $p = 0;
        }
        else {
            foreach ($results as $k => $v) {
                $answer = DB::table('answers')->where('id', $v)->first();
                if ($k == 'starttime'|| $k =='subject_id' || $k =='level_id'|| $k =="time"){
                    continue;
                }

                $answer = DB::table('answers')->where('id', $v)->first();
                if ($answer == null) {
                    continue;
                }
                $p += $answer->is_correct;
            }
        }
        $results = new Result;
        $results->user_id = $user_id;
        $results->level_id = $level_id;
        $results->subject_id =$subject_id;
        $results->mark = $p*4;
        $results->time = $time;
        $results->save();
        return view('tests.result', compact('p','time'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
