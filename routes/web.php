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

Route::get('/', 'ClickController@index')->name('clicks.index');

Route::get('click', 'ClickController@store')->name('clicks.store');

Route::get('success/{id}', 'ResponseController@success')->where('id', '[A-z0-9-]+')
    ->name('responses.success');

Route::get('error/{id}', 'ResponseController@error')->where('id', '[A-z0-9-]+')
    ->name('responses.error');

Route::resource('bad-domains', 'BadDomainController')->except([
    'show', 'destroy'
]);
