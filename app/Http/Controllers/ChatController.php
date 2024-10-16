<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bot;
class ChatController extends Controller
{
    function chatBox($webKey)  {
        $Counter=Bot::where('rid', $webKey)->count();
        return view('chat_box',['webKey'=>$webKey,'Counter'=>$Counter]);
    }
    function chatFull($webKey)  {
        $Counter=Bot::where('rid', $webKey)->count();
        return view('chat_full_v3',['webKey'=>$webKey,'Counter'=>$Counter]);
    }
    function chatFullV2($webKey,$backGround='black',$color='white')  {
        $namedColors = [
            'red', 'white', 'black', 'blue', 'green', 'yellow', 'purple', 'gray', 'brown', 'orange', 'pink'
        ];

        // Check if the background color is a named color, otherwise add the #
        if (!in_array(strtolower($backGround), $namedColors) && !str_starts_with($backGround, '#')) {
            $backGround = '#' . $backGround;
        }

        // Check if the color is a named color, otherwise add the #
        if (!in_array(strtolower($color), $namedColors) && !str_starts_with($color, '#')) {
            $color = '#' . $color;
        }

        $Counter=Bot::where('rid', $webKey)->count();
        return view('chat_full_v4',['webKey'=>$webKey,'Counter'=>$Counter,'backGround'=>$backGround,'color'=>$color]);
    }

}
