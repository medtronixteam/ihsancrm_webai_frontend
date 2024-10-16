<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\botchat;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Services\PayUService\Exception;
use Illuminate\Support\Facades\Log;

class WebAiHooks extends Controller
{
    public function intence(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);
          if ($validator->fails()) {
             $response=['status'=>404,"message"=>"Oops..! Token Missing "];
        }else{

          $bots=DB::table('bots')->where('rid',$request->token);
          if ($bots->count()>0) {
            $botData=$bots->get();
              $response=['status'=>200,"name"=>$botData[0]->bot_name,'message'=>$botData[0]->welcome_message,'logo'=>$botData[0]->bot_logo,'color'=>$botData[0]->bot_color];
          }else{
             $response=['status'=>404,"message"=>"Sorry..! Invalid token"];
          }

        }
        return response($response,$response['status']);

    }
    public function random(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'message' => 'required',
        ]);
          if ($validator->fails()) {
             $response=['status'=>404,"message"=>"Oops..! Token Missing "];
        }else{
            $Fake = [
                'Hi there, I\'m Jesse and you?',
                'Nice to meet you',
                'How are you?',
                'Not too bad, thanks',
                'What do you do?',
                'That\'s awesome',
                'Codepen is a nice place to stay',
                'I think you\'re a nice person',
                'Why do you think that?',
                'Can you explain?',
                'Anyway I\'ve gotta go now',
                'It was a pleasure chat with you',
                'Time to make a new codepen',
                'Bye',
                ':)'
            ];
            sleep(5);
            $response=['status'=>200,"message"=>$Fake[rand (0,8)]];
        }
        return response($response,$response['status']);

    }
      public function getData(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'token' => 'required',
        ]);
          if ($validator->fails()) {
             $response=['status'=>500,"message"=>"Invalid message"];
        }else{

             // $response = Http::asForm()->post(config('services.xxxx.xxBOTTRAINERxx').'/query', [

        try {
             $botID= \App\Http\Controllers\WebAiHooks::getBotbuRID($request->token);
            $message = botchat::create([
                'send_id' => 0,
                'bot_id' => $botID[0]->id,
                'receive_id' => $botID[0]->id,
                'is_bot' => 0,
                'sender_email' => null,
                'sender_name' =>null,
                'message' =>$request->message,
            ]);

             $apiResponse = Http::withHeaders([
                'Authorization' => config('services.xxxx.xxWEBxKEYxx'),
            ])->asForm()->post(config('services.xxxx.xxWEBxBOTxx').'/ask/query', [
                'uid' =>$botID[0]->uid,
                'query' => $request->message,
            ]);

            if($apiResponse->failed()):
                Log::info("web ai  :".$apiResponse);
                $response=['status'=>500,"message"=>"Something Went Wrong Try Later"];
            else:
            $ret= DB::table('botchats')->insert([
                    'send_id' => $botID[0]->id,
                    'bot_id' => $botID[0]->id,
                    'receive_id' => 0,
                    'is_bot' => 1,
                    'sender_email' => null,
                    'sender_name' =>null,
                    'message' => json_decode($apiResponse->body(),true)['response'],
                ]);
                if ($ret) {
                         $response=['status'=>200,"message"=>json_decode($apiResponse->body(),true)['response']];
                } else{
                        $response=['status'=>500,"message"=>"Bot not working"];

                }
            endif;

       } catch (\Exception $e) {
        Log::info("web ai  :".$e->getMessage());
            $response=['status'=>500,"message"=>"A error has been occurred at server side"];
        }




        }
        return response($response,200);

    }
    public static  function getBotbuRID($id)
    {


        $data=DB::table('bots')->where('rid',$id)->get()->toArray();
        return $data;
    }

}
