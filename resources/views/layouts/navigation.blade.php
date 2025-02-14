<?php 
    use App\Models\User;
    use App\Models\Message;

    $users = User::where('id', '!=', auth()->user()->id)->get();
    $unreadCount = Message::where('receiver_id', auth()->user()->id)->where('read',0)->count();

?>

<nav x-data="{ open: false, showMessages: false, selectedMessage: null, messages: [
    { id: 1, title: '📩 Message from Alex', content: 'Hey! How are you? Let’s catch up soon.' },
    { id: 2, title: '📅 Meeting at 3 PM', content: 'Don’t forget we have a meeting at 3 PM today.' },
    { id: 3, title: '⏳ Project Deadline Extended', content: 'The project deadline has been extended to next Friday.' }
] }" 
class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
        <div class="flex">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>
        </div>

        <!-- Right Side: Notifications & User Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:space-x-8 ">  
            
            <!-- Notification Bell -->
            <div class="relative" style="margin-right: 1rem;">
                <button @click="showMessages = !showMessages" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-2m-4.5 0a3 3 0 00-6 0m6 0v1a3 3 0 01-6 0v-1m9 0a6 6 0 10-12 0m6 9a3 3 0 003-3H9a3 3 0 003 3z"></path>
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{$unreadCount}}</span>
                </button>

                <!-- Messages Dropdown Container (800px wide) -->
                <div x-show="showMessages" @click.away="showMessages = false" 
                    class="absolute right-0 mt-8  flex w-[800px] bg-white dark:bg-gray-700 shadow-lg rounded-lg border border-gray-300 dark:border-gray-600 ">

                    <!-- Messages List (35% Width) -->
                    <div  class="w-2/5 px-6 border-r border-gray-300 dark:border-gray-600 ">
                        <h3 class="text-gray-800 dark:text-gray-200 font-semibold mb-2">Messages</h3>
                        <hr class="border-t border-gray-300">
                        @foreach ($users as $user)
                            <div class="flex  items-center space-x-3 p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg relative get-user" user-id={{$user->id}}>
                                <!-- User Avatar -->
                                <img src="{{asset('image/face28.jpg')}}" alt="User Avatar" class="w-7 h-7 rounded-full" >
                                <!-- Message Info -->
                                <div class="flex-1">
                                    <h4 class="text-gray-900 dark:text-gray-200 font-semibold flex items-center">
                                        {{$user->name}} 
                                        <!-- Chat Count Badge -->
                                        <span class="ml-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{$unreadCount}}</span>
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm truncate ">Hey! How are you? Let’s catch up soon.</p>
                                </div>
                            </div>  
                        @endforeach

                    </div>

                    <!-- Message Display Section (65% Width) -->
                        <div id="viewMessages" class="  w-3/5 p-4 bg-gray-100 dark:bg-gray-800 rounded-r-lg my-4 flex flex-col h-[600px]">

                        @include('layouts.ajax-messages')
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Hamburger Menu for Mobile -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
</nav>
