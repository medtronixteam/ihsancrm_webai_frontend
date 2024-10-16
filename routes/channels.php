<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;

use App\Models\User;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('pendingSMS',function($user){
//     return !empty($user);
// },['middleware' => 'websocket']);

Broadcast::channel('private-pendingSMS.{key}', function ($user, $key) {
    // Authorization logic here
    return  $key===1; // Modify to implement proper authorization logic
});
// Broadcast::channel('private-channel.{id}', function (Request $request, $id) {

//     return true;
// });

