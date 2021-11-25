<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;



class ChatMessage extends Model
{
    protected $fillable = ['message', 'sender_id', 'receiver_id', 'chat_id'];
    
        public function getCreatedAtAttribute($date)
        {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        
        public function getUpdatedAtAttribute($date)
        {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }

    public function conversation()
    {
        return $this->belongsTo('App\Http\Models\Chat','chat_id');
    }

    public function sender_id()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function receiver_id()
    {
        return $this->belongsTo('App\User', 'receiver_id', 'id');
    }
}
