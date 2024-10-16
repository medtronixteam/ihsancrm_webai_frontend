<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAiHooks;
use App\Http\Controllers\SMSAiHooks;
use App\Http\Controllers\WebSock;
use App\Http\Controllers\WhatsappTracking;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('web/instance', [WebAiHooks::class,'intence']);
Route::post('web/message', [WebAiHooks::class,'getData']);
Route::post('web/message/random', [WebAiHooks::class,'random']);

/*---------------------*/
Route::post('sms/v1/receive-sms', [SMSAiHooks::class,'receiveSMS']);
Route::post('sms/v2/receive-sms', [SMSAiHooks::class,'receiveSMS_two']);

Route::post('sms/v1/pending-sms', [SMSAiHooks::class,'pendingSMS']);
Route::post('sms/v1/change-status', [SMSAiHooks::class,'changeSMSStatus']);
Route::get('sms/v1/delete-pending', [SMSAiHooks::class,'deletePending']);

//sms receive hooks
Route::post('sms/v1/send/pending-sms', [SMSAiHooks::class,'storePendings']);


Route::post('sms/v1/check-key', [SMSAiHooks::class,'checkkey']);

//triger event of pending sms lv
Route::post('sms/web/socket', [WebSock::class,'sendPending']);

//triger event of pending sms at node ap
Route::post('sms/nj/socket', [WebSock::class,'sendPendingTonj']);


Route::get('whatsapp/tracking/{botId}', [WhatsappTracking::class,'whatsapptracking']);
Route::get('whatsapp/tracking/{botId}/{senderNumber}', [WhatsappTracking::class,'whatsapptrackingAll']);


use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Route::post('/auth', function (Request $request) {


        // Continue with the request handling
        // Your logic here

        $token = $request->header('token');
      //  $token = str_replace('Bearer ', '', $token);

        $user = User::where('email', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
      return  $token = $user->createToken('auth-token')->plainTextToken;

    $request->headers->set('Authorization', 'Bearer '.$token);
    return response()->json(['message' =>$request->header('Authorization')]);
    // $request->validate([
    //     'email' => 'required|email',
    //     'password' => 'required',
    // ]);

    // $user = User::where('email', $request->email)->first();

    // if (! $user || ! Hash::check($request->password, $user->password)) {
    //     return response()->json(['message' =>'r']);
    // }

    return $user->createToken('auth-token')->plainTextToken;


});


Route::middleware('auth:sanctum')->post('/broadcasting/auth', function (Request $request) {
    return Broadcast::auth($request);
});
