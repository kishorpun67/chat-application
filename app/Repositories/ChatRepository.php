<?php

namespace App\Repositories;

use App\Interfaces\ChatInterface;
use App\Models\Message;
use App\Models\User;

class ChatRepository implements ChatInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getChats() 
    {
        $message = Message::get();
        return $message;
    }
}
