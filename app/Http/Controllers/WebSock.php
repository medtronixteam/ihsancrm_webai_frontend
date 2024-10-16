<?php

namespace App\Http\Controllers;
use Validator;
use Auth;
use Illuminate\Http\Request;
use App\Models\Bot;
use App\Models\botchat;
use App\Events\oldSMS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Events\ClientDataReceived;

class WebSock extends Controller
{
    function sendPending(Request $request) {
        $validator = Validator::make($request->all(), [
            'bot_token' => 'required',
        ]);
          if ($validator->fails()) {
             $response=['status'=>404,"message"=>"Oops..! Token Missing "];
        }else{

            $pendingsms = DB::table('ai_sms')->select('id', 'body', 'to_person')->where('is_bot',1)->where('bot_id', $request->bot_token)->where('status', 'pending');
            if ($pendingsms->count() > 0) {
              event(new oldSMS($request->bot_token, $pendingsms->get()));
                 Log::info("pending sms data send:");
                $response = ['message' => "There is some sms for pending", 'status' => 200, 'data' => $pendingsms->get()];

            } else {
                Log::error("pending sms no pending sms");
                $response = ['message' => "Oops No SMS is Pending", 'status' => 200,'data' =>[],];
            }

        }
        return response($response,$response['status']);
    }
    public  function sendPendingTonj(Request $request) {
        $validator = Validator::make($request->all(), [
            'bot_token' => 'required',
        ]);
          if ($validator->fails()) {
             $response=['status'=>404,"message"=>"Oops..! Token Missing "];
        }else{

           $response= $this->triggerPendingSMS($request->bot_token);
        }
        return response($response,$response['status']);
    }


    public function store(Request $request)
    {
        // Validate and process the request data
        $data = $request->validate([
            'data' => 'required',
        ]);

        // Dispatch the event
        ClientDataReceived::dispatch($data['data']);

        return response()->json(['message' => 'Data received and processed'], 200);
    }
    public static function triggerPendingSMS($bot_token){

        $pendingsms = DB::table('ai_sms')->select('id', 'body', 'to_person','bot_id')->where('is_bot',1)->where('bot_id', $bot_token)->where('status', 'pending');
        if ($pendingsms->count() > 0) {
            try {

                 $apiResponse = Http::retry(3, 100)->withHeaders([
                        'Content-Type' => 'application/json',
                    ])->post('https://websocket.ihsancrm.com/api/pending/messages', [
                        'message' => $pendingsms->get(),
                        'token'=>$bot_token,
                    ]);

               if($apiResponse->failed()):

                   Log::info("Node Socket Error :".$apiResponse);
                   $response=['status'=>500,"message"=>"Something Went Wrong Try Later"];
               else:
                $response=['status'=>200,"message"=>"yES WE DID IT "];
               endif;

          } catch (\Exception $e) {
           Log::info("Node Socket Error 2  :".$e->getMessage());
               $response=['status'=>500,"message"=>"A error has been occurred at server side"];
           }
             Log::info("pending sms data send:");
            $response = ['message' => "There is some sms for pending", 'status' => 200, 'data' => $pendingsms->get()];

        } else {
            Log::error("pending sms no pending sms");
            $response = ['message' => "Oops No SMS is Pending", 'status' => 200,'data' =>[],];
        }
        return $response;
    }
}

