<?php
use Carbon\Traits\Rounding;
use App\Http\Controllers\ViewSettingController;

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
	return view('frontEnd.homepage');
});

Route::get('/about', function () {
	return view('frontEnd.about');
});

Route::get('/contact', 'SendContactFormController@index');
Route::post('/contact/send', 'SendContactFormController@send');

Route::get('/trial', 'SendTrialFormController@index');
Route::post('/trial/send', 'SendTrialFormController@send');

Route::get('/services', function () {
	return view('frontEnd.services');
});



Route::get('/privacy', function () {
	return view('frontEnd.privacy-policy');
});

Route::get('/cookies', function () {
	return view('frontEnd.cookie-policy');
});

/*
Route::get('/clear', function() {
   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');
	 Artisan::call('queue:restart');
   return "CACHE PULITA, EVVIVA LA VITA!";

});
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {

	/**
	 * Direct Access page
	 */
	Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

    Route::get('calendar', 'CalendarController@index')->name('calendar');
    Route::get('calendar/{id}', ['as' => 'patient_book', 'uses' => 'CalendarController@patient_book']);
    Route::post('available-create-patient', 'CalendarController@available_create_patient');
    Route::post('get-schedules', ['as' => 'schedules', 'uses' => 'CalendarController@schedules']);
    // Route::get('download-csv', 'CalendarController@download_csv');
    Route::get('reminder',['as' => 'calendar.downloadcsv', 'uses' => 'CalendarController@download_csv']);

    Route::get('patients', 'PatientController@index')->name('patients');
    Route::get('patients/{id}', ['as' => 'patients.edit', 'uses' => 'PatientController@edit']);
    Route::post('update-patient-info', ['as' => 'patients.update_info', 'uses' => 'PatientController@update_info']);
    Route::post('create-patient', ['as' => 'patients.create', 'uses' => 'PatientController@create']);
    Route::post('delete-patient', ['as' => 'patients.delete', 'uses' => 'PatientController@delete']);
    Route::post('update-patient', ['as' => 'patients.update', 'uses' => 'PatientController@update']);

    Route::post('create-schedule', ['as' => 'schedule.create', 'uses' => 'ScheduleController@create']);
    Route::post('delete-schedule', ['as' => 'schedule.delete', 'uses' => 'ScheduleController@delete']);
    Route::post('update-schedule', ['as' => 'schedule.update', 'uses' => 'ScheduleController@update']);

    Route::get('reports', 'ReportController@index')->name('reports');
    Route::get('report/{id}', 'ReportController@report')->name('report');
    Route::post('update-report', ['as' => 'reports.update', 'uses' => 'ReportController@update']);
    Route::post('get-report-data', ['as' => 'reports.get_report_data', 'uses' => 'ReportController@get_report_data']);

    Route::get('dentists', 'DentistController@index')->name('dentists');
    Route::get('dentists-management', 'DentistController@management')->name('dentists_management');
    Route::post('assign-manager', 'DentistController@assign_manager')->name('assign_manager');

    Route::get('users', 'UserController@index')->name('users');
    Route::get('new_user', 'UserController@create')->name('new_user');

    Route::any('cron-user-update', 'CronUserController@user_info_update');

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::post('update-status', 'UserController@updateStatus')->name('update_status');
    Route::post('delete-user', 'UserController@delete_user')->name('delete_user');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
