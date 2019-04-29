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
// everyone routes

Route::get('/', 'PagesController@index');
Route::get('/clear-cache',  'cache@clear');

// User Routes

Route::resource('/home', 'PostsController');
Auth::routes();
Route::get('/menu', 'MenuSopStaff@index_menu');
Route::get('/rota', 'HomeController@rota');
Route::get('/rota/{week}', 'HomeController@toggleWeek');
Route::get('/sop', 'MenuSopStaff@index_sop');
Route::get('/account', 'HomeController@account');
Route::get('/download/{week}', 'HomeController@pdf')->name('download');
Route::get('/emailUpdate', 'UserAccount@email');
Route::put('/emailUpdate/{id}', 'UserAccount@updateEmail');
Route::get('/passwordUpdate', 'UserAccount@password');
Route::put('/passwordUpdate/{id}', 'UserAccount@updatePassword');

Route::get('/preview/{week}', 'HomeController@rotaToPrint');

// Admin Routes

Route::get('admin/home', 'AdminController@index')->name('admin.home');
Route::get('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin','Admin\LoginController@login');
Route::post('admin-password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::post('admin-password/reset', 'Admin\ResetPasswordController@reset')->name('admin.password.update');
Route::get('admin-password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::get('admin-password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::resource('/admin-rota', 'RotaController');
Route::resource('/rota-draft', 'DraftsController');
Route::resource('admin-post', 'AdminPostsController');
Route::resource('/admin-menu', 'MenuController');
Route::resource('/admin-sop', 'SOPController');

Route::get('/manageAccounts', 'AccountsController@index');
Route::get('/adminEmail', 'AccountsController@email');
Route::put('/adminEmail/{id}', 'AccountsController@updateEmail');
Route::get('/adminPassword', 'AccountsController@password');
Route::put('/adminPassword/{id}', 'AccountsController@updatePassword');
Route::get('/manageUsers', 'AccountsController@users');
Route::get('/updateUser/{id}', 'AccountsController@editUser');
Route::put('/updateUser/{id}', 'AccountsController@updateUser');
Route::delete('/manageUsers/{id}', 'AccountsController@deleteUser');
