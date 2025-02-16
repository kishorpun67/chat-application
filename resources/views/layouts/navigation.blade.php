<?php 
    use App\Models\User;
    use App\Models\Message;

    $users = User::where('id', '!=', auth()->user()->id)->get();
    $unreadCount = Message::where('receiver_id', auth()->user()->id)->where('read', 0)->count();
?>

<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
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
            <div class="hidden sm:flex sm:items-center sm:space-x-8">  
                
                <!-- Notification Bell -->
                <div class="" style="margin-right: 1rem;">
                    <button onclick="toggleMessages()" class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-2m-4.5 0a3 3 0 00-6 0m6 0v1a3 3 0 01-6 0v-1m9 0a6 6 0 10-12 0m6 9a3 3 0 003-3H9a3 3 0 003 3z"></path>
                        </svg>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{$unreadCount}}</span>
                    </button>

                    <!-- Messages Dropdown -->
                    <div id="messagesDropdown" class="absolute hidden display right-1 mt-8  flex flex-col w-[800px] bg-white dark:bg-gray-700 shadow-lg rounded-lg border border-gray-300 dark:border-gray-600">
                        <!-- Header with Remove Button -->
                        <div class="flex  justify-between items-center px-6 py-2 bg-gray-200 dark:bg-gray-800 rounded-t-lg">
                            <h3 class="text-gray-800 dark:text-gray-200 font-semibold">Messages</h3>
                            <button onclick="removeMessages()" class="text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                ❌ Remove
                            </button>
                        </div>

                        <div class="flex h-[600px]">
                            <!-- Messages List -->
                            <div class="w-2/5 px-6 border-r border-gray-300 dark:border-gray-600 ">
                                {{-- <hr class="border-t border-gray-300"> --}}
                                <div class="my-2"></div>
                                @foreach ($users as $user)
                                    <div class="flex items-center space-x-3 p-2  cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg get-user" user-id={{$user->id}}>
                                        <img src="{{ asset('image/face28.jpg') }}" alt="User Avatar" class="w-7 h-7 rounded-full">
                                        @if($user->isOnline())
                                            <span class="text-success">🟢 </span>
                                        @else
                                            <span class="text-muted"></span>
                                        @endif
                                        <div class="flex-1 overflow-hidden whitespace-nowrap">
                                            <h4 class="text-gray-900 dark:text-gray-200 font-semibold flex items-center">
                                                {{ $user->name }}
                                            </h4>
                                        </div>
                                    </div>  
                                @endforeach
                            </div>

                            <!-- Message Display Section -->
                            <div id="viewMessages" class="w-3/5  bg-gray-100 dark:bg-gray-800 rounded-r-lg  flex flex-col">
                                @include('layouts.ajax-messages')
                            </div>
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

        </div>
    </div>
</nav>


