<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Validator;

class SMSAiHooks extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 2200);
    }
    public function smsLoing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]);
        if ($validator->fails()) {

            $response = ['message' => $validator->messages(), 'status' => 400];
        } else {

            $user = User::where('email', $request->email)->first();
            // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => 'These credentials do not match our records.', 'status' => 404,
                ], 404);
            }

            $token = $user->createToken('my-app-token')->plainTextToken;
            unset($user->id);
            unset($user->role);
            unset($user->referral_id);
            unset($user->refer_by);
            $user->once_plan_active = strval($user->once_plan_active);
            $response = [
                'user' => $user,
                'token' => $token,
                'message' => "Login in Successfully.",
                'status' => 200,

            ];
        }
        return response($response, $response['status']);

    }
    public function receiveSMS(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'from_person' => 'required',
            'bot_id' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = json_decode(json_encode($validator->messages()), true);

            $response = ['message' => reset($messages)[0], 'status' => 500];
        } else {
            // getBot(1)[0]->bot_id

            try {
                $SMSAiHooks = $this->getBotSMSKey($request->bot_id);
                $isValidPhoneNumber = \App\Http\Controllers\SMSAiHooks::isValidPhoneNumber($request->from_person);

                if ($SMSAiHooks && $isValidPhoneNumber) {
                    // code...
                    if ($SMSAiHooks[0]->is_sms_linked == 1):
                        // return $SMSAiHooks[0]->uid;
                        $ai_sms = DB::table('ai_sms')->insert([
                            'user_id' => $SMSAiHooks[0]->user_id,
                            'bot_id' => $request->bot_id,
                            'is_bot' => 0,
                            'status' => 'success',
                            'to_person' => str_replace(' ', '', str_replace('+', '', $request->from_person)),
                            'from_person' => str_replace(' ', '', str_replace('+', '', $request->from_person)),
                            'body' => $request->message,
                        ]);

                        $url=str_replace(' ', '', config('services.xxxx.xxSMSAIxx').'/give/response');
                        $apiResponse = Http::withHeaders([
                            'Authorization' => config('services.xxxx.xxSMSKEYxx'),
                        ])->asForm()->timeout(150)->post("https://smsbot.ihsancrm.com/api/sms/give/response", [
                            'name' => $SMSAiHooks[0]->uid,
                            'number' => str_replace(' ', '', str_replace('+','', $request->from_person)),
                            'query' => $request->message,
                        ]);
                        Log::info("receive sms :".$SMSAiHooks[0]->uid);
                        Log::info("receive sms :".$apiResponse);
                        if ($apiResponse->failed()):
                            Log::info("receive sms :".$apiResponse);

                            if ($apiResponse->status() == 404) {
                                DB::table('bots')->where('smsAiToken',  $request->bot_id)->update(['is_sms_linked' => 0]);
                                $response = ['status' => 404, "message" => "Session Not found." ];
                            }else{
                                $response = ['status' => 500, "message" => $apiResponse->status()." Something Went Wrong Try Later." ];
                            }


                        else:
                            $response = ['message' => "message has been query to bot", 'status' => 201];

                        endif;
                    else:
                        $response = ['status' => 500, "message" => "Bot is not linked"];
                    endif;
                } else {

                    $response = ['status' => 500, "message" => "Invalid  Phone Number or Bot Key "];
                }

            } catch (\Exception $e) {
                Log::info("receive sms:" . $e->getMessage());
                $response = ['status' => 500, "message" => $e->getMessage()];

            }

        }
        return response($response, $response['status']);

    }
    public static function getBotSMSKey($id)
    {

        $data = DB::table('bots')->where('smsAiToken', $id);
        if ($data->count() > 0) {
            return $data->get();
        } else {
            return false;
        }

    }
    public static function isValidPhoneNumber($number)
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        $pattern = '/^(\+?)([0-9]{8,15})$/';

        return preg_match($pattern, $number) === 1;
    }

    public function  checkkey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sms_key' => 'required',
        ]);
        if ($validator->fails()) {
            $response = ['message' => $validator->messages(), 'status' => 500];
        } else {

            $data = DB::table('bots')->where('smsAiToken', $request->sms_key)->where('is_sms_linked',1);
            if ($data->count() > 0) {
                $smsAiToken=$data->get();
                $response = ['message' => "Great Key is valid", 'status' => 200, 'name' =>$smsAiToken[0]->bot_name, 'uid' =>$smsAiToken[0]->uid ];
            } else {
                $response = ['message' => "Invalid Key", 'status' => 404];
            }
        }
        return response($response, $response['status']);
    }
    public function pendingSMS(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bot_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = ['message' => $validator->messages(), 'status' => 500];
        } else {
            Log::info("pending sms Traggered:");
            $SMSAiHooks = \App\Http\Controllers\SMSAiHooks::getBotSMSKey($request->bot_id);
            $pendingsms = DB::table('ai_sms')->select('id', 'body', 'to_person')->where('bot_id', $request->bot_id)->where('status', 'pending');
            if ($pendingsms->count() > 0) {
            Log::info("pending sms data send:");
                $response = ['message' => "There is some sms for pending", 'status' => 200, 'data' => $pendingsms->get()];

            } else {
                Log::error("pending sms no pending sms");
                $response = ['message' => "Oops No SMS is Pending", 'status' => 200,'data' =>[],];
            }

        }
        return response($response, $response['status']);
    }
    public function changeSMSStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'sms_id' => 'required',
        ]);
        if ($validator->fails()) {
            Log::info("change status invalid key:");
            $response = ['message' => $validator->messages(), 'status' => 500];
        } else {

            $pendingsms = DB::table('ai_sms')->where('id', $request->sms_id);
            if ($pendingsms->count()>0) {

                $pendingsms->update(['status' => 'success']);
                $response = ['message' => "Status has been updated",'data'=>$pendingsms->first(), 'status' => 200];

            } else {

                $response = ['message' => "Invalid Id ", 'status' => 500];
            }

        }
        return response($response, $response['status']);
    }
    public function deletePending()
    {
        $pendingsms = DB::table('ai_sms')->where('status', 'pending')->delete();
        $response = ['message' => "Pending sms deleted ", 'status' => 200];
        return response($response, $response['status']);


    }
    public function storePendings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'to_person' => 'required',
            'message' => 'required',
            'query'=>'required',
        ]);
        if ($validator->fails()) {
            $response = ['message' => $validator->messages(), 'status' => 500];
        } else {
            //$SMSAiHooks= \App\Http\Controllers\SMSAiHooks::getBotSMSKey($request->token);
            $SMSAiHooksCheck = DB::table('bots')->where('smsAiToken', $request->token);
            if ($SMSAiHooksCheck->count() > 0) {
                // code...

                $SMSAiHooks = $SMSAiHooksCheck->get();

                if($request->query!="survey_started" OR $request->query!="survey_ended"){
                    DB::table('ai_sms')->insert(
                        [
                            'status' => 'success',
                            'user_id' => $SMSAiHooks[0]->user_id,
                            'bot_id' => $SMSAiHooks[0]->smsAiToken,
                            'is_bot' => 0,
                            'body' =>$request->get('query'), 'from_person' => $request->to_person, 'to_person' => $request->to_person]);

                }
                $pendingsms = DB::table('ai_sms')->insert(
                    [
                        'status' => 'pending',
                        'user_id' => $SMSAiHooks[0]->user_id,
                        'bot_id' => $SMSAiHooks[0]->smsAiToken,
                        'is_bot' => 1,
                        'body' => $request->message, 'from_person' => $request->to_person, 'to_person' => $request->to_person]);

                if ($pendingsms) {
                    //envent
                  WebSock::triggerPendingSMS($SMSAiHooks[0]->smsAiToken);
                    $response = ['message' => "Data has been Inserted", 'status' => 200];

                }
            } else {
                $response = ['message' => "Invalid token ...oops", 'status' => 500];
            }

        }
        return response($response, $response['status']);
    }

    public function receiveSMS_two(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'from_person' => 'required',
            'bot_id' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = json_decode(json_encode($validator->messages()), true);

            $response = ['message' => reset($messages)[0], 'status' => 500];
        } else {
            // getBot(1)[0]->bot_id

            try {
              //  $SMSAiHooks = $this->getBotSMSKey($request->bot_id);
                $SMSAiHooks = \App\Http\Controllers\SMSAiHooks::getBotSMSKey($request->bot_id);
                $isValidPhoneNumber = $this->isValidPhoneNumber($request->from_person);

                if ($SMSAiHooks && $isValidPhoneNumber) {
                    // code...
                    if ($SMSAiHooks[0]->is_sms_linked == 1):
                        $ai_sms = DB::table('ai_sms')->insert([
                            'user_id' => $SMSAiHooks[0]->user_id,
                            'bot_id' => $request->bot_id,
                            'is_bot' => 0,
                            'status' => 'success',
                            'to_person' => str_replace(' ', '', str_replace('+', '', $request->from_person)),
                            'from_person' => str_replace(' ', '', str_replace('+', '', $request->from_person)),
                            'body' => $request->message,
                        ]);

                        $apiResponse = Http::withHeaders([
                            'Authorization' => config('services.xxxx.xxWEBxKEYxx'),
                        ])->asForm()->post(config('services.xxxx.xxWEBxBOTxx').'/ask/query', [
                            'uid' =>$SMSAiHooks[0]->uid,
                            'query' => $request->message,
                        ]);
                        if ($apiResponse->failed()):
                            if ($apiResponse->status() == 404) {
                                DB::table('bots')->where('smsAiToken',  $request->bot_id)->update(['is_sms_linked' => 0]);
                                $response = ['status' => 404, "message" => "Session Not found." ];
                            }else{
                                $response = ['status' => 500, "message" => "Something Went Wrong Try Later." ];
                            }
                        else:
                            $ai_sms = DB::table('ai_sms')->insert([
                                'user_id' => $SMSAiHooks[0]->user_id,
                                'bot_id' => $request->bot_id,
                                'is_bot' => 1,
                                'status' => 'pending',
                                'to_person' => str_replace(' ', '', str_replace('+', '', $request->from_person)),
                                'from_person' => str_replace(' ', '', str_replace('+', '', $request->from_person)),
                                'body' =>$apiResponse['response'],
                            ]);
                            $response = ['message' => $apiResponse['response'], 'status' => 201];
                        endif;


                    else:
                        $response = ['status' => 500, "message" => "Bot is not linked"];
                    endif;
                } else {

                    $response = ['status' => 500, "message" => "Invalid  Phone Number or Bot Key "];
                }

            } catch (\Exception $e) {
                Log::info("receive sms:" . $e->getMessage());
                $response = ['status' => 500, "message" => $e->getMessage()];

            }

        }
        return response($response, $response['status']);

    }
}
