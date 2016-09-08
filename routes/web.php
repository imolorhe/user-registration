<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/confirm-email/{confirmation_code}', 'Auth\RegisterController@confirmEmail')->name('confirmEmail');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', function(){
  return redirect('/');
});

Route::get('/edit/{id}', 'HomeController@editProfile')->name('editProfile');
Route::post('/edit/{id}', 'HomeController@updateProfile')->name('updateProfile');
Route::post('/delete/{id}', 'HomeController@deleteProfile')->name('deleteProfile');
Route::get('/create', 'HomeController@createProfile')->name('createProfile');
Route::post('/create', 'HomeController@saveProfile')->name('saveProfile');