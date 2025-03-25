<?php

namespace App\Http\Controllers;

use App\Services\RoleGreeting;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    public $roleGreeting;
    public function __construct(RoleGreeting $roleGreeting)
    {
        $this->roleGreeting = $roleGreeting;
    }   
    public function index($role=null)
    {
        return $this->roleGreeting->getGreeting($role);
    }
}
