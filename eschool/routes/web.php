<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PostController@index')->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

/* admin user control */

Route::get('/accs', function () {
    if (\Illuminate\Support\Facades\Auth::user()->role == 'teacher')
    {
        return view('admin');
    }
    else{
        return view('welcome');
    }
})->middleware('auth');
Route::post('/showacc','AdminController@showacc')->name('showacc')->middleware('auth');
Route::post('/delacc','AdminController@delacc')->name('delacc')->middleware('auth');
/*Post*/
Route::get('/loadpost', 'PostController@index')->middleware('auth');
Route::post('/loadpost/loadmore','PostController@loadpost')->name('loadpost')->middleware('auth');
Route::post('/post','PostController@store')->name('posts')->middleware('auth');
Route::get('/manager','PostController@manager')->middleware('auth');
Route::post('/allpost','PostController@allpost')->name('allpost')->middleware('auth');
Route::post('/delpost','PostController@delpost')->name('delpost')->middleware('auth');


Route::get('/post/show/{id}', 'PostController@showpost')->name('posts.show')->middleware('auth');
Route::get('/wall/{user_id}','PostController@wall')->middleware('auth')->middleware('auth');
Route::post('/wall/loadmore','PostController@wallpost')->name('wall')->middleware('auth');

Route::post('/comment', 'PostController@postcmt')->name('comment')->middleware('auth');
Route::post('/comment/like', 'CommentController@like')->name('comment.like')->middleware('auth');
Route::post('/loadcomment/loadmore','PostController@loadcomment')->name('loadcmt')->middleware('auth');
Route::post('/changelike', 'CommentController@changelike')->name('changelike')->middleware('auth');
Route::post('/delcmt','PostController@delcmt')->name('delcmt')->middleware('auth');


Route::get('/showprofile', 'ShowProfileController@index')->name('profiles.show');
Route::post('/showprofile', 'ShowProfileController@index');

Route::get('/editprofile', 'EditProfileController@index')->name('profiles.edit');
Route::post('/editprofile', 'EditProfileController@store')->name('profiles.store');

/* Do test */
Route::get('/dotest', 'TestController@testform')->middleware('auth');
Route::get('/test', 'TestController@test');
Route::get('/result', 'TestController@result');

/* Teacher add question */
Route::get('/add_question_form','TestController@addQuestionForm');
Route::post('/add_question','TestController@addQuestion');

//user profiles v2
Route::get('/showprofile', 'ShowProfileController@index')->name('profiles.show');
Route::post('/showprofile', 'ShowProfileController@index')->name('profiles.show');

Route::get('/editprofile', 'EditProfileController@index')->name('profiles.edit');
Route::post('/editprofile', 'EditProfileController@store')->name('profiles.store');

//route graph
Route::post('/showmark', 'ShowProfileController@showmark')->name('showmark');
Route::get('/showmark', 'ShowProfileController@showmark')->name('showmark');

//pasword
Route::get('/changePassword','HomeController@showChangePasswordForm')->name('showChange');

Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

//Notification
Route::post('/notify','NotifyController@shownotify')->name('notifications');
Route::post('/notify/load','NotifyController@notify')->name('notify');
Route::get('/activity','NotifyController@showact');
Route::post('/activity/load','NotifyController@activity')->name('activity');

//Testing route
Route::get('create',function (){
    return view('create_acc');
});
Route::post('dm_register','AdminController@adm_register')->name('adm_register');
