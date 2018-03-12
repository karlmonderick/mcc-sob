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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group( function(){
    Route::get('/home', 'HomeController@index')->name('home');
        
    Route::resource('activities', 'ActivityController');
    Route::resource('academic_years', 'AcademicYearController');
    Route::resource('institutes', 'InstituteController');
    Route::resource('organization_academic_years', 'OrganizationAcademicYearController');
    Route::resource('organizations', 'OrganizationController');
    Route::resource('cash_request', 'CashRequestController');
    Route::resource('notifications', 'NotificationController');
    Route::resource('funds', 'FundsController');
    Route::resource('roles', 'RoleController');
    Route::resource('officers_voting', 'OfficerController');
    Route::resource('users', 'UserController');
    Route::resource('enrolled_ay', 'EnrolledAcademicYearController');
    Route::resource('savings', 'SavingController');
    Route::resource('budget', 'BudgetController');
    Route::resource('reports', 'ReportsController');
    Route::resource('calendar_of_activities', 'CalendarActivitiesController');
    Route::resource('liquidations', 'LiquidationController');

    
    Route::resource('enrolled_students', 'EnrolledStudentsController');

    Route::post('/toggle-notify','NotificationController@add_content');
    Route::post('/toggle-notifications','NotificationController@notifications');
    Route::post('/toogle-organization-notifications', 'NotificationController@org_notify');
    Route::post('/toggle-approve','ActivityController@approval');
    Route::post('/toggle-approve','ActivityController@approval');
    Route::post('/toggle-approve2','ActivityController@approval2');
    Route::post('/toggle-disapprove','ActivityController@disapproval');
    Route::post('/toggle-approve3','ActivityController@approval3');
    Route::post('/toggle-disapprove3','ActivityController@disapproval3');
    Route::get('/officers/show/{id}','OfficerController@show_officers')->name('officers.show_officers');
    Route::post('/officers/show','OfficerController@store_officers')->name('officers.store_officers');
    Route::post('/Institute','InstituteController@store2')->name('institutes.store2');
    Route::delete('/officers/{id}','OfficerController@destroy')->name('officers.destroy');
    Route::delete('/officers/edit/{id}','OfficerController@edit')->name('officers.edit');
    Route::get('/activities/print/{id}','ActivityController@print')->name('activities.print');
    Route::get('/activities/show/{id}','ActivityController@view_content')->name('activities.view_content');
    Route::get('/reports/print/{id}','ReportsController@print')->name('reports.print');
    
    Route::get('/funds/create/{id}','FundsController@create_funds')->name('funds.create_funds');

    Route::post('/academic_years','AcademicYearController@add_year')->name('academic_year.add_year');

    Route::post('/budget','BudgetController@get_budget')->name('budgets.get_budget');

    Route::post('organization_academic_years/{id}', 'OrganizationAcademicYearController@refresh_list')->name('organization_academic_years.refresh_list');
    Route::get('/organization_academic_years/info/{id}','OrganizationAcademicYearController@view_info')->name('organization_academic_years.view_info');

    Route::post('/funds','FundsController@allocate_funds')->name('funds.allocate_funds');

    Route::get('/liquidations/show/{id}','LiquidationController@view_content')->name('liquidations.view_content');
    Route::post('/toggle2-approve','LiquidationController@approval');
    Route::post('/toggle2-disapprove','LiquidationController@disapproval');
    Route::post('/toggle2-notify','NotificationController@add_content2');


    Route::post('upload', 'LiquidationController@upload');
    Route::post('upload_image', 'UserController@upload_image');
    Route::post('upload_org_logo', 'OrganizationController@upload_org_logo');
    
    
    


});


Auth::routes();


