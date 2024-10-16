<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class botchat extends Model
{
    use HasFactory;
    protected $fillable = [
        'send_id',
        'bot_id',
        'receive_id',
        'is_bot',
        'sender_email',
        'sender_name',
        'message',
    ];
}
