<?php

namespace App\Services\GreetingStrategies;

use App\Interfaces\GreetingInterface;

class PublisherGreeting implements GreetingInterface
{
    
    public function greet():string {
        return "Hey Publisher! How are you";
    }
}
