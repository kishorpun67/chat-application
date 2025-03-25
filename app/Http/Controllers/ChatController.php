<?php

namespace App\Http\Controllers;

use App\Interfaces\ChatInterface;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public $chatInterface;
    public function __construct(ChatInterface $chatInterface)
    {
        $this->chatInterface = $chatInterface;
    }

    public function index()
    {
        $chats = $this->chatInterface->getChats();
        return $chats;
    }
}
