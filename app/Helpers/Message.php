<?php
    use App\Models\Message;

    function latestMessage($user_id){
        $messages = Message::where(function ($query) use ($user_id) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $user_id);
        })
        ->orWhere(function ($query) use ($user_id) {
            $query->where('sender_id', $user_id)
                  ->where('receiver_id', auth()->id());
        })
        ->orderBy('created_at', 'desc') // Order messages by latest
        ->first();  // Get the latest message
        return $messages->message ?? '';
    }
?>