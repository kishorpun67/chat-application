<?php

namespace App\Http\Controllers;

use App\Singletons\Logger;
use Illuminate\Http\Request;

class SecondController extends Controller
{
    public function dumpLogFromSecondController ( $message)
    {
        $log = Logger::getInstance();
        $log->dumplog($message);
    }
}
