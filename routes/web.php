<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ChatController;

use App\Events\newSMS;
use App\Events\oldSMS;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  //  abort(404);
  return view('welcome');
});
Route::get('/clear-cache', function () {
    \Artisan::call('optimize:clear');
    return 'Cache cleared';
});
Route::get('/download-log', [LogController::class, 'downloadLog']);



Route::get('/chat/box/v1/{webKey}', [ChatController::class, 'chatBox']);
Route::get('/chat/full/v1/{webKey}', [ChatController::class, 'chatFull']);
Route::get('/chat/full/v2/{webKey}/{backGround?}/{color?}', [ChatController::class, 'chatFullV2']);

Route::get('/event', function () {
    event(new newSMS('1', ['hey you dude']));
    return "DOne";
});
Route::get('/events', function () {
    event(new oldSMS('1', ['hey you dude']));
    return "DOne";
});

use App\Http\Controllers\WebSock;
Route::post('/receive-data',  [WebSock::class, 'store']);
