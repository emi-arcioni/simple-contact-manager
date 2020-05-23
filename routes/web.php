<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index');

    // -- Contacts URLs --
    Route::get('/contacts', 'ContactsController@index');

    Route::post('/contacts', 'ContactsController@store');
    Route::put('/contacts/{contact_id}', 'ContactsController@store');

    Route::get('/contacts/new', 'ContactsController@form');
    Route::get('/contacts/{contact_id}', 'ContactsController@form');

    Route::delete('/contacts/{contact_id}', 'ContactsController@delete');
    // --

    Route::get('/settings', 'SettingsController@form');
    Route::post('/settings', 'SettingsController@store');
    Route::put('/settings/{setting_id}', 'SettingsController@store');
});
