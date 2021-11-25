<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Chat extends Model
{
    protected $fillable = ['participant_1_id','participant_2_id'];
    
      public function getCreatedAtAttribute($date)
        {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        
        public function getUpdatedAtAttribute($date)
        {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }

    public function chatMessage(){
    	return $this->hasMany(ChatMessage::class,'chat_id','id');
    }
    
      public function participant_1()
    {
        return $this->belongsTo('App\User', 'participant_1_id', 'id');
    }

    public function participant_2()
    {
        return $this->belongsTo('App\User', 'participant_2_id', 'id');
    }

    // public function user_id()
    // {
    //     return $this->belongsTo('App\User', 'user_id', 'id');
    // }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
