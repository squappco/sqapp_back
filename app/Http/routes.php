<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::group(['middleware' => ['squapp']], function () {
    Route::post('fields/{fields}/score', 'FieldController@setScore');
    Route::get('fields/{fields}/games', 'FieldController@getGames');
    Route::resource('fields', 'FieldController');

    Route::post('games/{games}/players/join', 'GameController@addPlayer');
    Route::post('games/{games}/players/remove', 'GameController@removePlayer');
    Route::get('games/{games}/players', 'GameController@getPlayers');
    Route::resource('games', 'GameController');

    Route::post('players/{players}/score', 'PlayerController@setScore');
    Route::resource('players', 'PlayerController');

    Route::resource('clients', 'ClientController');

    Route::get('billing', 'BillingController@index');

    Route::get('mygames', 'PlayerController@getMyGames');
});
