<?php

namespace App\Singletons;

use Illuminate\Support\Facades\Log;

use function Pest\Laravel\instance;

class Logger
{

    private static $instance = null;

    private function __construct()
    {
        
    }

    private function __clone()
    {
        
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");

    }
    public static function getInstance() {
        if(self::$instance == null) {

            self::$instance = new self();
        }
        return self::$instance;
    }
    public function dumplog($message)
    {
        $objectId =  spl_object_id($this);
        Log::info("$message Object id is: {$objectId}" );
    }
}
