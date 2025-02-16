
@if(isset($messages))
    <h3 class=" text-gray-900  bg-green-100 p-4 font-bold flex items-center justify-center">
        {{$user->name}} 
    </h3>  
        <!-- Chat Messages Container -->
        <div class="flex-1 p-4 overflow-y-auto mb-4 space-y-4" id="showMessage">

            @foreach ($messages as $message)
            @if ($message->sender_id == auth()->user()->id)
                <!-- Sent Message (Right) -->

                <div class="flex justify-end my-1" >
                    <div class="max-w-[70%] bg-blue-700  text-white rounded-lg p-2" >
                        <p>{{$message->message}}</p>
                        <span class="text-xs text-blue-200  block">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @else
                        <!-- Incoming Message (Left) -->
            <div class="flex justify-start my-1">
                <div class="max-w-[70%] bg-white dark:bg-gray-700 rounded-lg p-2">
                    <p class="text-gray-800 dark:text-gray-200">
                        {{$message->message}}
                    </p>
                    <span class="text-xs text-gray-500 dark:text-gray-400  block">{{ $message->created_at->diffForHumans() }}</span>
                </div>
            </div>

            @endif
            @endforeach
        </div>
    

        <!-- Message Input Area -->
        <div class="mt-auto mb-4">
            <div class="flex items-center space-x-2 px-4">
                <input 
                    type="text" 
                    id="message"
                    placeholder="Type your message..." 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500"
                >
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors send-message">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.289l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.288l-7-14z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

@endif
<input type="hidden" id="receiver_id" value="">

