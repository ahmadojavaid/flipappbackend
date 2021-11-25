<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Controllers\Api\ApiController;
use App\Http\Models\Chat;
use App\Http\Models\ChatMessage;
use App\Http\Models\ProductSale;
use Illuminate\Support\Facades\Validator;
use Auth;

class ChatController extends ApiController
{
    public function getChats(){
    	// $chats = Chat::selectRaw('chat_messages.created_at,chat_messages.chat_id,chat_messages.message,chat_messages.sender_id,chat_messages.receiver_id')
    	$chats = Chat::selectRaw('chats.id,chat_messages.*')
    				->where(function($qry){
    					// $qry->where('chats.conversation_start','seller');
    					// $qry->where('chats.user_id',Auth::user()->id)
    					// 	->orWhere('chats.receiver_id',Auth::user()->id)
    					// 	->where('chats.conversation_start','seller');
    						// $qry->where(function($q){
	    					// 	$q->where('chats.user_id',Auth::user()->id)
	    					// 	->orwhere('chats.receiver_id',Auth::user()->id);
	    					// })->where('chats.conversation_start','seller');
    				})
    				->leftjoin('chat_messages','chat_messages.chat_id','=','chats.id')
    				->whereIn('chat_messages.created_at',function($qry){
    					$qry->selectRaw('MAX(chat_messages.created_at)')
    						->from('chat_messages')
    						->where('chat_messages.sender_id',Auth::user()->id)
    						->orWhere('chat_messages.receiver_id',Auth::user()->id)
    						->groupBy('chat_id');
    				})->get();

  
    	$arr = [
    		'chats'		=>	$chats,
    	];
    	$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Chats Fetched Successfully';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);

    }
    public function postSellerChat(Request $request){

    	$validator = Validator::make($request->all(), [
                        'message'  				=> 'required',
                        'receiver_id' 			=> 'required',
                    ]);
        if ($validator->fails()) {
            $errorMsg = $validator->messages();
            $this->apiHelper->statusCode     = 0;
            $this->apiHelper->statusMessage  = 'Validation Error!';
            $this->apiHelper->result         = $errorMsg;
            return response()->json($this->apiHelper->responseParse(),422);
        }

        $sender_id = Auth::user()->id;


        $message = new ChatMessage();
        $message->fill($request->all());
        $message->sender_id = $sender_id;

        if(!$request->chat_id){

            $conversation = Chat::create([
                 'participant_1_id' => $sender_id,
                'participant_2_id' => $request->receiver_id
            ]);

            $message->chat_id = $conversation->id;

        }else{
            $message->conversation->touch();
    	}
        $message->save();

        $message = ChatMessage::with(['sender_id' => function($q) {
            return $q->select(['users.id', 'user_name', 'profile_image']);
        }])

            ->with(['receiver_id' => function($q) {
                return $q->select(['users.id', 'user_name', 'profile_image']);
            }])

//            ->with('chat_id,user_id')
            ->where('id', $message->id)->first();

        $arr = [
            'Messages' => $message
        ];
        $this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Message send Successfully';
        $this->apiHelper->result         = $arr;
        return response()->json($this->apiHelper->responseParse(),200);
    }

    public function getChatMessages(Request $request){

        $user_id = Auth::user()->id;

        $response = [

            'next_offset' => (int)$request->offset + 20,

            'conversations' => Chat::with(['participant_1' => function($q) {
                return $q->select(['users.id', 'user_name', 'profile_image']);
            }])
                ->with(['participant_2' => function($q) {
                    return $q->select(['users.id', 'user_name', 'profile_image']);
                }])
                ->with(['chatMessage' => function($q){
                    return $q->select(['id', 'message', 'chat_id','created_at'])
                        ->orderBy('created_at', 'desc')
                        ->take(1);
                }])
                ->where('participant_1_id', $user_id)
                ->orWhere('participant_2_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->take(1)
                ->offset($request->offset)
                ->get()
        ];

//    	$arr = [
//    		'Messages' => $response
//    	];
    	$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Message Fetched Successfully';
        $this->apiHelper->result         = $response;
        return response()->json($this->apiHelper->responseParse(),200);
    }
    public function getBuyerChats(Request $request){
        $user_id = Auth::user()->id;

        $response = [
            'next_offset' => (int)$request->offset + 20,
            'conversation' => Chat::with('participant_1:users.id,first_name,last_name,profile_image')
            ->with('participant_2:users.id,first_name,last_name,profile_image')
                ->with(['chatMessage' => function($q) use ($request) {
                    return $q->select(['id', 'message', 'sender_id', 'receiver_id', 'chat_id','created_at'])
                        ->orderBy('created_at', 'desc')
                        ->offset($request->offset)
                        ->take(20);
                }])
                ->where('id', $request->chat_id)
                ->first()
        ];

    	$this->apiHelper->statusCode     = 1;
        $this->apiHelper->statusMessage  = 'Chats Fetched Successfully';
        $this->apiHelper->result         = $response;
        return response()->json($this->apiHelper->responseParse(),200);
    }
}
