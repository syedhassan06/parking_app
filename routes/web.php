<?php

Route::group(['middleware' => 'guest'],function (){
    Route::get('login', 'AuthenticationController@getLogin')->name('get_login');
    Route::post('login', 'AuthenticationController@authenticate')->name('post_login');
    Route::get('signup','AuthenticationController@getSignup')->name('get_signup');
    Route::post('signup', 'AuthenticationController@signup')->name('post_signup');
});




Route::group(['middleware' => ['auth','web']], function (){

    Route::get('logout', 'AuthenticationController@logout')->name('logout');
    Route::get('/', function (){
        return redirect()->route('booking_manage');
    });

    Route::group(['prefix' => 'user','middleware' => ['can:isAdmin']], function () {
        Route::get('list', ['uses' => 'UserController@getAll', 'as' => 'user_list']);
        Route::get('manage', ['uses' => 'UserController@index', 'as' => 'user_manage']);
        Route::get('add', ['uses' => 'UserController@create', 'as' => 'user_create']);
        Route::get('edit/{id}', ['uses' => 'UserController@create', 'as' => 'user_edit']);
        Route::post('save', ['uses' => 'UserController@save', 'as' => 'user_save']);
        Route::post('activate', ['uses' => 'UserController@activate', 'as' => 'user_activate']);
    });

    Route::group(['prefix' => 'booking','middleware' => ['web']], function () {
        Route::get('list', ['uses' => 'BookingController@getAllBookings', 'as' => 'booking_list']);
        Route::get('manage', ['uses' => 'BookingController@index', 'as' => 'booking_manage']);
        Route::get('add', ['uses' => 'BookingController@create', 'as' => 'booking_create']);
        Route::get('details/{id}', ['uses' => 'BookingController@details', 'as' => 'booking_details']);
        Route::post('save', ['uses' => 'BookingController@save', 'as' => 'booking_save']);
        Route::post('fetch-booking', ['uses' => 'BookingController@getParkingSlotsByDuration', 'as' => 'api_fetch_booking']);
        Route::post('cancel/{id?}', ['uses' => 'BookingController@cancelled', 'as' => 'api_booking_cancel']);

    });

    Route::group(['prefix' => 'feedback','middleware' => ['web']], function () {
        Route::post('fetch-user-reply', ['uses' => 'FeedbackController@getUserReplies', 'as' => 'api_user_reply']);
        Route::post('post-user-reply', ['uses' => 'FeedbackController@postUserReplies', 'as' => 'api_post_user_reply']);
        Route::get('reply', ['uses' => 'FeedbackController@userReplies', 'as' => 'feedback_reply'])->middleware('can:isAdmin');
        Route::get('write', ['uses' => 'FeedbackController@write', 'as' => 'feedback_write'])->middleware('can:isCustomer');
        Route::post('save', ['uses' => 'FeedbackController@save', 'as' => 'feedback_save']);

    });

});


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

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
