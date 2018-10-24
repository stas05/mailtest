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
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function()
{
   Route::get('/', 'AdminController@main')->name('admin-dashboard');
   Route::resource('/invites', 'InviteController', ['as' => 'admin']);
   Route::post('/invites/send', 'InviteController@send')->name('admin.invites.send');
   Route::resource('/users', 'UserController', ['as' => 'admin']);
});

Route::get('/invites/{inviteCode}', 'Admin\UserController@wachIvite');
Route::get('/invite/{user}', 'UserController@getUserByInvite')->name('invited-user');
Route::post('/invite/{user}', 'UserController@postUserByInvite')->name('user-change');


Route::get('/home', 'HomeController@index')->name('home');
Route::view('/about-us', 'welcome')->name('aboutUs');
Route::view('/form', 'welcome')->name('feedbackForm');
