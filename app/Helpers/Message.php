<?php
    use App\Models\Message;

    function undreadMessage($user_id){
        $messages = Message::where(function ($query) use ($user_id) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $user_id);
        })->where('read',0)
        ->first();  // Get the latest message
        return $messages->message ?? '';
    }
?>