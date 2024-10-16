<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $headers = ['content-type' => 'application/json', 'x-api-key' => config('services.xxxx.xxxWHATs_KEYxxx')];
            $response = Http::withHeaders($headers)->get(config('services.xxxx.xxxWHATs_URLxxx') . '/sessions?all=true');
            if ($response->failed() and $response->status() != 200):

            else:
                if (count(json_decode($response, true)) > 0):
                    $workingArray = [];
                    //    Log::info('whatsapp response : ' . $response);
                    foreach (json_decode($response, true) as $val):

                        if ($val['status'] == 'WORKING') {

                            $workingArray[] = $val['name'];
                            DB::table('bots')->where('rid', '=', $val['name'])->update(['what_number' =>$val['me']['id'], 'what_status' => 'WORKING', 'is_whats_linked' => 1, 'status_updated_at' => Carbon::now()->toDateTimeString()]);
                        }

            endforeach;

            $totalData= DB::table('bots')->where('is_whats_linked', 1)->get();
            foreach ($totalData as $key => $data) {
                if(in_array($data->rid, $workingArray)){
                    DB::table('bots')->where('rid', '=', $data->rid)->update(['what_status' => 'WORKING', 'is_whats_linked' => 1]);

                }else{
                    Notification::create([
                        'to_user' => $data->user_id,
                        'notification'=>"Your Bot ".$data->bot_name." has been Unlinked from Whatsapp Ai.",
                    ]);

                    DB::table('bots')->where('rid', '=', $data->rid)->update(['what_status' => 'CLOSED', 'is_whats_linked' => 0]);
                }
            }


            // if (count($workingArray) > 0):
            //     DB::table('bots')->whereIn('rid', $workingArray)->update(['is_whats_linked' => 1, 'what_status' => 'WORKING']);
            //     DB::table('bots')->whereNotIn('rid', $workingArray)->update(['is_whats_linked' => 0, 'what_status' => 'CLOSED']);
            // else:
            //     Log::info('whats all cleared ');
            //     DB::table('bots')->update(['is_whats_linked' => 0, 'what_status' => 'CLOSED']);
            // endif;

            else:
                Log::info('whats all cleared ');
                DB::table('bots')->update(['is_whats_linked' => 0, 'what_status' => 'CLOSED']);

            endif;
            endif;
        })->everyFiveMinutes();
        $schedule->call(function () {
            $response = Http::withHeaders([
                'Authorization' => config('services.xxxx.xxFBxKEYxx'),
            ])->asForm()->timeout(130)->get(config('services.xxxx.xxFBxAIxx') . '/sessions');
            if ($response->failed()):

            else:
                if (count(json_decode($response, true)) > 0):
                    $notArray = [];
                    $workingArray = [];
                    foreach (json_decode($response, true) as $val):
                        $notArray[] = $val['name'];
                        if ($val['status'] == 'WORKING') {
                            $workingArray[] = $val['name'];
                            DB::table('bots')->where('face_account_name', '=', $val['name'])->update(['is_face_linked' => 1]);

                        } else {
                            Log::info('fb delinked :' . $val['name']);
                            DB::table('bots')->where('face_account_name', '=', $val['name'])->update(['is_face_linked' => 0]);
                        }
                    endforeach;
                    if (count($workingArray) > 0):
                        DB::table('bots')->whereIn('face_account_name', $workingArray)->update(['is_face_linked' => 1]);
                        DB::table('bots')->whereNotIn('face_account_name', $workingArray)->update(['is_face_linked' => 0]);
                    else:
                        Log::info('fb all cleared ');
                        DB::table('bots')->update(['is_face_linked' => 0]);
                    endif;
                else:
                    Log::info('fb all cleared ');
                    DB::table('bots')->update(['is_face_linked' => 0]);
                endif;
            endif;
        })->everyFiveMinutes();

        $schedule->call(function () {
            $response = Http::withHeaders([
                'Authorization' => 'za-cWiJDJMlz7TFJh1l42z7MC0VM9ZaTBwdCZaTDFKl13BlbkFJ',
            ])->asForm()->timeout(130)->get('https://instagram.ihsancrm.com/api/insta/sessions');
            if ($response->failed()):

            else:
                $notArray = [];
                $workingArray = [];
                if (count(json_decode($response, true)) > 0):
                    $namearray = array_column(json_decode($response, true), 'name');
                    Log::info('name array ' . $namearray);
                    foreach (json_decode($response, true) as $val):
                        $notArray[] = $val['name'];
                        if ($val['status'] == 'WORKING') {
                            $workingArray[] = $val['name'];
                            DB::table('bots')->where('insta_account_name', '=', $val['name'])->update(['is_insta_linked' => 1]);

                        } else {
                            Log::info('insta delinked :' . $val['name']);
                            $checkEitherLinked = DB::table('bots')->where('insta_account_name', '=', $val['name']);
                            if ($checkEitherLinked->count() > 0 && $checkEitherLinked->get()->is_insta_linked == 1):
                                $checkEitherLinked->update(['is_insta_linked' => 0]);
                            endif;
                            DB::table('bots')->where('insta_account_name', '=', $val['name'])->update(['is_insta_linked' => 0]);
                        }
                    endforeach;
                    if (count($workingArray) > 0):
                        DB::table('bots')->whereIn('insta_account_name', $workingArray)->update(['is_insta_linked' => 1]);
                        DB::table('bots')->whereNotIn('insta_account_name', $workingArray)->update(['is_insta_linked' => 0]);
                    else:
                        Log::info('insta all cleared ');
                        DB::table('bots')->update(['is_insta_linked' => 0]);
                    endif;
                else:
                    Log::info('insta all cleared ');
                    DB::table('bots')->update(['is_insta_linked' => 0]);
                endif;
            endif;
        })->everyFiveMinutes();

        $schedule->call(function () {
            $response = Http::withHeaders([
                'Authorization' => config('services.xxxx.xxSMSKEYxx'),
            ])->asForm()->timeout(130)->get(config('services.xxxx.xxSMSAIxx') . '/sessions');
            if ($response->failed()):

            else:
                if (count(json_decode($response, true)) > 0):
                    $notArray = [];
                    $workingArray = [];
                    foreach (json_decode($response, true) as $val):
                        $notArray[] = $val['name'];
                        if ($val['status'] == 'STARTED' || $val['status'] == 'CREATED') {
                            $workingArray[] = $val['name'];
                            DB::table('bots')->where('uid', '=', $val['name'])->update(['is_sms_linked' => 1]);

                        } else {
                            Log::info('SMS delinked :' . $val['name']);
                            DB::table('bots')->where('uid', '=', $val['name'])->update(['is_sms_linked' => 0]);
                        }
                    endforeach;
                    if (count($workingArray) > 0):
                        DB::table('bots')->whereIn('uid', $workingArray)->update(['is_sms_linked' => 1]);
                        DB::table('bots')->whereNotIn('uid', $workingArray)->update(['is_sms_linked' => 0]);
                    else:
                        Log::info('SMS all cleared ');
                        DB::table('bots')->update(['is_sms_linked' => 0]);
                    endif;
                else:
                    Log::info('SMS all cleared ');
                    DB::table('bots')->update(['is_sms_linked' => 0]);

                endif;
            endif;
        })->everyFiveMinutes();

        $schedule->call(function () {

            $pendingsms = DB::table('ai_sms')->select('id', 'body', 'to_person','status')->where('is_bot',1)->where('status', 'pending');
            foreach($pendingsms as $pendSms):
            try {

                $apiResponse = Http::retry(3, 100)->withHeaders([
                       'Content-Type' => 'application/json',
                   ])->post('https://websocket.ihsancrm.com/api/pending/messages', [
                       'message' => $pendSms,
                       'token'=>$pendSms->bot_id,
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
        endforeach;
        })->everyTwoMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
