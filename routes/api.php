<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('detail', 'API\UserController@detail');
Route::post('gantipassword', 'API\UserController@gantipassword');
Route::post('editprofile', 'API\UserController@editprofile');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    Route::post('logout', 'API\UserController@logout');

    //post
    Route::get('allpost','API\PostController@index');
    Route::post('mypost','API\PostController@myPost');
    Route::post('newpost','API\PostController@newPost');
    Route::post('updatepost','API\PostController@updatePost');
    Route::post('deletepost','API\PostController@deletePost');
    Route::post('detailpost','API\PostController@detailPost');
    Route::get('post/search/{search}','API\PostController@search');

    Route::post('newkomentar','API\PostController@newKomentar');
    Route::post('deletekomentar','API\PostController@deleteKomentar');

    Route::get('notif/findby','FirebaseNotificationController@findBy');
    Route::get('notif/claimed','FirebaseNotificationController@claimed');
    Route::get('notif/verification','FirebaseNotificationController@verification');
    Route::get('notif/verified','FirebaseNotificationController@verified');
    Route::get('notif/verificationConfirmed','FirebaseNotificationController@verificationConfirmed');
    Route::get('notif/verificationRejected','FirebaseNotificationController@verificationRejected');
    Route::get('notif','FirebaseNotificationController@allNotif');


});



