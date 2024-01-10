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

Route::get('/', "GameController@Home")->Name('Home');
Route::post('/register/process', "GameController@RegisterProcess")->Name('RegisterProcess');
Route::post('/login/process', "GameController@LoginProcess")->Name('LoginProcess');
Route::get('/logout', "GameController@Logout")->Name('Logout');

Route::prefix('room')->group(function () {
    Route::post('/create', "GameController@RoomCreate")->Name('RoomCreate');

    Route::get('/join', "GameController@RoomJoin")->Name('RoomJoin')->middleware('redirectIfAuth');
    Route::post('/joining', "GameController@RoomJoining")->Name('RoomJoining');

    Route::get('/waiting', "GameController@RoomWaiting")->Name('RoomWaiting')->middleware('redirectIfAuth');
    Route::post('/poll/players', "GameController@pollPlayers")->Name('pollPlayers');

    Route::post('/change/status', "GameController@ChangeStatus")->Name('ChangeStatus');
    Route::post('/disconnect', "GameController@RoomDisconnect")->Name('RoomDisconnect');

    Route::post('/start', "GameController@StartGame")->Name('StartGame');

    Route::get('/start', "GameController@RoomPlay")->Name('RoomPlay')->middleware('redirectIfAuth');

    Route::post('/start/timer', "GameController@StartTimer")->Name('StartTimer');

    Route::post('/poll/cards', "GameController@pollCards")->Name('pollCards');

    Route::post('/round/card/add', "GameController@CardAdd")->Name('CardAdd');
});