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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/contacts', 'ContactsController@get')->name('contacts');

Route::get('/conversation/{id}', 'ContactsController@getMessagesFor');

Route::post('/conversation/send', 'ContactsController@send');
