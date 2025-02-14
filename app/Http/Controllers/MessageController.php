<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Models\Message;
class MessageController extends Controller
{
  public function index(Request $request) 
  {
    $data = request()->all();

    //get all message data
    $messages = Message::where(function($query) use($data){
        $query->where('sender_id', auth()->user()->id)
              ->where('receiver_id', $data['user_id']);
    })->orWhere(function($query) use($data){
        $query->where('sender_id', $data['user_id'])
              ->where('receiver_id', auth()->user()->id);
    })
    ->with('sender:id,name', 'receiver:id,name')
    ->get();

    // marked as read 
    Message::where(['receiver_id'=>auth()->user()->id, 'sender_id'=>$data['user_id']])->update(['read'=>1]);
    return view('layouts.ajax-messages',['messages'=>$messages]);
  }

  public function create(Request $request)
  {

    $data = $request->all();
    // return $data;
    $newMessage = new Message();
    $newMessage->sender_id = auth()->user()->id;
    $newMessage->receiver_id = $data['receiver_id'];
    $newMessage->message = $data['message'];  
    $newMessage->read = false;
    $newMessage->save();
    broadcast(new NewMessage($newMessage))->toOthers();
    return response()->json(['message'=>$newMessage,'receiver_id'=>$data['receiver_id'], 'auth_id'=>auth()->user()->id]);
  }
}
