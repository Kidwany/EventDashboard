<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth'], function ()
{

    Route::get('/', 'DashboardController@index');

    Route::resource('product', 'ProductController');
    Route::resource('event', 'EventController');
    Route::get('event/{id}/print', 'EventController@printQr');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:::::::::::::::::::::::::::::  Applicants Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('applicants/{event_id}', 'ApplicantsController@index');
    Route::get('applicants/accept/{id}', 'ApplicantsController@acceptRequest');
    Route::get('applicants/reject/{id}', 'ApplicantsController@rejectRequest');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:::::::::::::::::::::::::::::  Organizers Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('organizers/{event_id}', 'OrganizersController@index');
    Route::get('organizers/accept/{event_id}/{user_id}', 'ApplicantsController@acceptRequest');
    Route::get('organizers/reject/{event_id}/{user_id}', 'OrganizersController@rejectRequest');


    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:::::::::::::::::::::::::::::::::  Groups Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('groups/{event_id}', 'GroupsController@index');
    //Route::get('groups/{event_id}/{group_id}', 'GroupsController@show');
    Route::get('groups/{event_id}/create', 'GroupsController@create');
    Route::post('groups/{event_id}/store', 'GroupsController@store');
    Route::patch('groups/update/{id}', 'GroupsController@update');
    Route::get('groups/edit/{event_id}/{group_id}', 'GroupsController@edit');
    Route::delete('groups/delete/{group_id}', 'GroupsController@destroy');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::  Event Floors  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('floors/{event_id}', 'FloorsController@index');
    Route::get('floors/create', 'FloorsController@create');
    Route::post('floors/store', 'FloorsController@store');
    Route::get('floors/{id}/edit', 'FloorsController@edit');
    Route::patch('floors/{id}/update', 'FloorsController@update');
    Route::delete('floors/{id}/delete', 'FloorsController@destroy');
    Route::get('floors/{id}/print', 'FloorsController@printQr');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::  Tools Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('tools/{event_id}', 'ToolsController@index');
    Route::get('tools/create', 'ToolsController@create');
    Route::post('tools/store', 'ToolsController@store');
    Route::get('tools/{id}/edit', 'ToolsController@edit');
    Route::patch('tools/{id}/update', 'ToolsController@update');
    Route::delete('tools/{id}/delete', 'ToolsController@destroy');
    Route::get('tools/{id}/print', 'ToolsController@printQr');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::  Gates Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('gates/{event_id}', 'GatesController@index');
    Route::get('gates/create', 'GatesController@create');
    Route::post('gates/store', 'GatesController@store');
    Route::get('gates/{id}/edit', 'GatesController@edit');
    Route::patch('gates/{id}/update', 'GatesController@update');
    Route::delete('gates/{id}/delete', 'GatesController@destroy');
    Route::get('gates/{id}/print', 'GatesController@printQr');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::  Tasks Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('tasks/{event_id}', 'TasksController@index');
    //Route::get('groups/{event_id}/{group_id}', 'GroupsController@show');
    Route::get('tasks/{event_id}/create', 'TasksController@create');
    Route::post('tasks/{event_id}/store', 'TasksController@store');
    Route::patch('tasks/update/{id}', 'TasksController@update');
    Route::get('tasks/edit/{event_id}/{group_id}', 'TasksController@edit');
    Route::delete('tasks/delete/{group_id}', 'TasksController@destroy');

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:::::::::::::::::::::::::::::::: Tracking Routes  ::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::get('tracking/{event_id}', 'TrackingController@index');
    Route::get('tracking/{event_id}/map', 'TrackingController@map');
    //Route::get('groups/{event_id}/{group_id}', 'GroupsController@show');
    Route::get('tasks/{event_id}/create', 'TasksController@create');
    Route::post('tasks/{event_id}/store', 'TasksController@store');
    Route::patch('tasks/update/{id}', 'TasksController@update');
    Route::get('tasks/edit/{event_id}/{group_id}', 'TasksController@edit');
    Route::delete('tasks/delete/{group_id}', 'TasksController@destroy');


    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:::::::::::::::::::::::::::::::::::  Admins  :::::::::::::::::::::::::::::::*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    Route::resource('admin', 'AdminController');


    /* Users Controller*/
    Route::resource('user', 'UserController');
    Route::get('print-user/{id}', 'UserController@printPdf');
    Route::get('printid/{id}', 'UserController@printIdPdf');


    /* Notification Controller*/
    Route::resource('notification', 'NotificationController');

    Route::get('message', 'MessageController@index');
    Route::get('message/{id}', 'MessageController@show');

    /*--------  Contact   --------*/
    Route::get('contact/edit', 'ContactController@edit');
    Route::patch('contact/update', 'ContactController@update');

    Route::post('files/{id}/{group_id}/delete', 'FilesControleer@destroy');

    Route::get('/logout', 'DashboardController@logout');

});

Auth::routes();

Route::post('/admin-login', 'LoginController@authenticate');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test/{id}', function ($id){
    $user = \App\Models\User::with('serviceProviderJobs')->find($id);
    $events = \App\Models\Event::with('serviceProvider')->where('sp_id', $id)->get();
    $total_user_events = \App\Models\Event::with('serviceProvider')->where('sp_id', $id)->count();
    $sp_experience = \App\Models\ServiceProviderExperience::where('user_id', $id)->get();
    $sp_doc = \App\Models\UserDocuments::with('identityImage')->where('user_id', $id)->first();
    $requests = \App\Models\EventAttendRequest::where('user_id', $id)->count();
    return view('printUser', compact('user', 'events', 'total_user_events', 'sp_experience', 'sp_doc', 'requests'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
