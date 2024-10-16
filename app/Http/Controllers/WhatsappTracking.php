<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WhatsappTracking extends Controller
{
    public function whatsapptracking($botID) {
        $whatai_chats = DB::table('whatai_chats')
        ->select('bots.bot_name as bot_name','bots.rid as rid','whatai_chats.client_number',)
        ->distinct()
        ->join('bots', 'whatai_chats.bot_rid', '=', 'bots.rid')->where('bots.rid',$botID);
        if($whatai_chats->count()>0){
            return response()->json(['message' => $whatai_chats->get(),'status'=>200], 200);
        }else{
            return response()->json(['message' => 'No Data Found','status'=>404], 404);
        }
    }
    public function whatsapptrackingAll($botID,$senderNumber) {
        $chatData = DB::table('whatai_chats')
        ->select('whatai_chats.*')
         ->where('bot_rid', $botID)
         ->where('client_number', $senderNumber)
         ->orderBy('created_at', 'desc')
         ;

     // Group the chat messages by date

        if($chatData->count()>0){
            $groupedChats=$chatData->get();
            $whatai_chats = $groupedChats->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('Y-m-d');
            });
            $botData = DB::table('bots')->where('rid', $botID)->first();

            return response()->json(['message' => $whatai_chats,'bot_name'=>$botData->bot_name,'status'=>200], 200);
        }else{
            return response()->json(['message' => 'No Data Found','status'=>404], 404);
        }
    }
}
