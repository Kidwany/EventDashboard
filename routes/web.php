<?php

use App\Models\Event;
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

Route::get('dev', function () {

    $evenTitle=Event::where('id',65)->select('title')->firstOrFail();
   return $evenTitle->title;
});

Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth'], function ()
{
    Route::group(['middleware' => ['docs_not_uploaded', 'approved']], function ()
    {
        Route::resource('event', 'EventController');
        Route::resource('season', 'SeasonController');
        Route::get('event/{id}/print', 'EventController@printQr');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*:::::::::::::::::::::::::::::  Applicants Routes  ::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('applicants/{event_id}', 'ApplicantsController@index');
        Route::get('applicants/accept/{id}', 'ApplicantsController@acceptRequest');
        Route::post('applicants/accept/{id}/user-page', 'ApplicantsController@acceptRequestFromUserPage');
        Route::get('applicants/reject/{id}', 'ApplicantsController@rejectRequest');
        Route::get('contract/{application_id}/verify', 'ApplicantsController@verifyContract');
        Route::get('verify-contract', 'ApplicantsController@verified');

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
        /*::::::::::::::::::::::::::::::::::  Event Zones  :::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('zones/{event_id}', 'ZoneController@index');
        Route::get('zones/{event_id}/create', 'ZoneController@create');
        Route::post('zones/store', 'ZoneController@store');
        Route::get('zones/{id}/edit', 'ZoneController@edit');
        Route::patch('zones/{id}/update', 'ZoneController@update');
        Route::delete('zones/{id}/delete', 'ZoneController@destroy');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::  Event Company  :::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('company/{event_id}', 'CompanyController@index');
        //Route::get('company/{event_id}/show/{company_id}', 'CompanyController@show');
        Route::get('company/{event_id}/create', 'CompanyController@create');
        Route::post('company/store', 'CompanyController@store');
        Route::get('company/{id}/edit', 'CompanyController@edit');
        Route::patch('company/{id}/update', 'CompanyController@update');
        Route::delete('company/{id}/delete', 'CompanyController@destroy');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::: Event Company Users ::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('company-user', 'CompanyUserController@index');
        Route::get('company-user/{id}', 'CompanyUserController@index');
        Route::get('company-user/{id}/create', 'CompanyUserController@create');
        Route::post('company-user/store', 'CompanyUserController@store');
        Route::get('company-user/{id}/edit', 'CompanyUserController@edit');
        Route::patch('company-user/{id}/update', 'CompanyUserController@update');
        Route::delete('company-user/{id}/delete', 'CompanyUserController@destroy');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::: Event Company Group ::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        //Route::get('company-group', 'CompanyGroupController@index');
        Route::get('company-group/{id}', 'CompanyGroupController@index');
        Route::get('company-group/{id}/create', 'CompanyGroupController@create');
        Route::post('company-group/store', 'CompanyGroupController@store');
        Route::get('company-group/{id}/edit', 'CompanyGroupController@edit');
        Route::patch('company-group/{id}/update', 'CompanyGroupController@update');
        Route::delete('company-group/{id}/delete', 'CompanyGroupController@destroy');

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
        /*::::::::::::::::::::::::::::::  Guardian Ship Routes  ::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('guardian-ship/{event_id}', 'GuardianShipController@index');
        Route::get('guardian-ship/{event_id}/create', 'GuardianShipController@create');
        Route::post('guardian-ship/{event_id}/store', 'GuardianShipController@store');
        Route::get('guardian-ship/{id}/edit', 'GuardianShipController@edit');
        Route::patch('guardian-ship/{id}/update', 'GuardianShipController@update');
        Route::delete('guardian-ship/{id}/delete', 'GuardianShipController@destroy');
        Route::get('guardian-ship/{id}/print', 'GuardianShipController@printQr');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*:::::::::::::::::::::::::::::::::  Break Routes  :::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('break/{event_id}', 'BreakController@index');
        Route::get('break/{event_id}/create', 'BreakController@create');
        Route::post('break/{event_id}/store', 'BreakController@store');
        Route::get('break/{id}/edit', 'BreakController@edit');
        Route::patch('break/{id}/update', 'BreakController@update');
        Route::delete('break/{id}/delete', 'BreakController@destroy');
        Route::get('break/{id}/print', 'BreakController@printQr');
        Route::get('break/{id}/add-break-to-user/{user_id}', 'BreakController@getBreakPage');
        Route::post('break/add-break-to-user', 'BreakController@addBreakToUser');

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


        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::  Finance Routes  ::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('finance/{event_id}', 'FinanceController@index');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::  Package Routes  ::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('package', 'PackageController@index');
        Route::get('package/consumption', 'PackageController@show');
        Route::post('package/subscribe', 'PackageController@subscribe')->name('package-subscribe');
        Route::get('package/subscription-cancelled', 'PaypalController@cancelled')->name('cancelled');
        Route::get('package/subscription-status', 'PaypalController@status')->name('status');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*:::::::::::::::::::::::::::  Expected Expenses Routes  :::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('expected_expenses/{event_id}', 'ExpectedExpensesController@index');
        Route::get('expected_expenses/create', 'ExpectedExpensesController@create');
        Route::post('expected_expenses/store', 'ExpectedExpensesController@store');
        Route::get('expected_expenses/{id}/edit', 'ExpectedExpensesController@edit');
        Route::patch('expected_expenses/{id}/update', 'ExpectedExpensesController@update');
        Route::delete('expected_expenses/{id}/delete', 'ExpectedExpensesController@destroy');


        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*:::::::::::::::::::::::::::::::::  Tickets Routes  :::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('tickets/{event_id}', 'TicketsController@index');
        Route::get('tickets/create', 'TicketsController@create');
        Route::post('tickets/store', 'TicketsController@store');
        Route::get('tickets/{id}/edit', 'TicketsController@edit');
        Route::patch('tickets/{id}/update', 'TicketsController@update');
        Route::delete('tickets/{id}/delete', 'TicketsController@destroy');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::  Sponsors Routes  :::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('sponsors/{event_id}', 'SponsorsController@index');
        Route::get('sponsors/create', 'SponsorsController@create');
        Route::post('sponsors/store', 'SponsorsController@store');
        Route::get('sponsors/{id}/edit', 'SponsorsController@edit');
        Route::patch('sponsors/{id}/update', 'SponsorsController@update');
        Route::delete('sponsors/{id}/delete', 'SponsorsController@destroy');

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        /*:::::::::::::::::::::::::::::::::  Spaces Routes  ::::::::::::::::::::::::::*/
        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        Route::get('spaces/{event_id}', 'SpacesController@index');
        Route::get('spaces/create', 'SpacesController@create');
        Route::post('spaces/store', 'SpacesController@store');
        Route::get('spaces/{id}/edit', 'SpacesController@edit');
        Route::patch('spaces/{id}/update', 'SpacesController@update');
        Route::delete('spaces/{id}/delete', 'SpacesController@destroy');


        /* Users Controller*/
        Route::resource('user', 'UserController');
        Route::get('print-user/{id}', 'UserController@printPdf');
        Route::get('printid/{id}', 'UserController@printIdPdf');
    });

    Route::get('/', 'DashboardController@index')->middleware('docs_not_uploaded');

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


Route::post('/admin-login', 'LoginController@authenticate');
Route::post('/company-register', 'RegisterController@authenticate');
Route::get('complete-register', 'RegisterController@completeRegister');
Route::post('complete-register', 'RegisterController@submitCompanyInfo')->name('complete_register');

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
