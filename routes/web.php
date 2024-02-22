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

Route::get('/', "WebpagesController@HomePage")->Name('HomePage');
Route::get('/about', "WebpagesController@AboutPage")->Name('AboutPage');
Route::get('/account', "WebpagesController@AccountPage")->Name('AccountPage');
Route::get('/login', "WebpagesController@LoginPage")->Name('LoginPage');
Route::get('/register', "WebpagesController@RegisterPage")->Name('RegisterPage');
Route::get('/rule', "WebpagesController@RulePage")->Name('RulePage');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', "AdminController@Dashboard")->Name('Dashboard');

    Route::get('/players', "AdminController@Players")->Name('Players');
    Route::post('/player/add', "AdminController@SubmitPlayerAdd")->Name('SubmitPlayerAdd');
    Route::post('/player/edit', "AdminController@SubmitPlayerEdit")->Name('SubmitPlayerEdit');
    Route::post('/player/delete', "AdminController@SubmitPlayerDelete")->Name('SubmitPlayerDelete');

    Route::get('/levels', "AdminController@Levels")->Name('Levels');
    Route::post('/level/add', "AdminController@SubmitLevelAdd")->Name('SubmitLevelAdd');
    Route::post('/level/edit', "AdminController@SubmitLevelEdit")->Name('SubmitLevelEdit');
    Route::post('/level/delete', "AdminController@SubmitLevelDelete")->Name('SubmitLevelDelete');

    Route::get('/nightmares', "AdminController@Nightmares")->Name('Nightmares');
    Route::post('/nightmare/add', "AdminController@SubmitNightmareAdd")->Name('SubmitNightmareAdd');
    Route::post('/nightmare/edit', "AdminController@SubmitNightmareEdit")->Name('SubmitNightmareEdit');
    Route::post('/nightmare/delete', "AdminController@SubmitNightmareDelete")->Name('SubmitNightmareDelete');

    Route::get('/cards', "AdminController@Cards")->Name('Cards');
    Route::post('/card/add', "AdminController@SubmitCardAdd")->Name('SubmitCardAdd');
    Route::post('/card/edit', "AdminController@SubmitCardEdit")->Name('SubmitCardEdit');
    Route::post('/card/delete', "AdminController@SubmitCardDelete")->Name('SubmitCardDelete');
});

Route::prefix('game')->group(function () {
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
    
});