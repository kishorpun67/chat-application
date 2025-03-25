<?php

namespace App\Http\Controllers;

use App\Singletons\Logger;
use Illuminate\Http\Request;
use App\Http\Controllers\SecondController;

class SingletonController extends Controller
{
    // public $logger;

    // public function __construct(Logger $logger)
    // {
    //     $this->logger = $logger;
    // }
    public function singletonExample() 
    {

        $log = Logger::getInstance();
        // $cloneSingle = clone $log;
        // $serilze = serialize($log);
        // dd($log, unserialize($serilze));
        $log->dumplog('sinlgeton log message');


        $log->dumplog('this second looger');
        
        $scondController = new SecondController;
        $scondController->dumpLogFromSecondController('hello sencod controller');
    }
}
