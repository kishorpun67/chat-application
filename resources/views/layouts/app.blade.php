<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth-id" content="{{ auth()->id() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- JavaScript for Show/Remove -->
<script>
    function toggleMessages() {
        let dropdown = document.getElementById("messagesDropdown");
        dropdown.classList.toggle("hidden");
    }

    function removeMessages() {
        let dropdown = document.getElementById("messagesDropdown");
        dropdown.classList.add("hidden");
    }
</script>
<script>
    $(document).ready(function () {
        
        var receiver_id;
        let auth_id = $('meta[name="auth-id"]').attr('content'); // Get auth user ID
        $(document).on("click", ".get-user", function () {
            console.log(Echo.connector.socketId)
            let user_id = $(this).attr('user-id');
            $("#receiver_id").val(user_id);
            receiver_id = user_id
            console.log("Receiver ID Set:", user_id); 

            $.ajax({
                method: 'get',
                url: '/get/messages',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    user_id: user_id,
                },
                success: function (response) {
                    $("#viewMessages").html(response);

                },
                error: function (xhr, status, error) {
                    console.error("Error:", error); 
                    alert("Error sending message!");
                }
            });
        });

        $(document).on('click', '.send-message', function () {
            // let receiver_id = $("#receiver_id").val();
            let message = $("#message").val();
            if(message){
                $("#message").val(" ");
                console.log("Sending message to:", receiver_id, "Message:", message); // Debugging

                $.ajax({
                    method: 'POST',
                    url: '/send/message',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        receiver_id: receiver_id,
                        message: message
                    },
                    success: function (response) {
                        console.log("Message Sent:", response); // Debugging
                        if (response.auth_id == response.message.sender_id) {
                            $("#showMessage").append(`
                                <div class="flex justify-end my-1">
                                    <div class="max-w-[70%] bg-blue-700 text-white rounded-lg p-2">
                                        <p>${response.message.message}</p>
                                        <span class="text-xs text-blue-200  block">${response.message.date}</span>
                                    </div>
                                </div>`
                            );
                            (`#preMessage-${auth_id}`).text(response.message.message)
                        } else {
                            $("#showMessage").append(`
                                <div class="flex justify-start my-1">
                                    <div class="max-w-[70%] bg-white dark:bg-gray-700 rounded-lg p-2">
                                        <p class="text-gray-800 dark:text-gray-200">
                                            ${response.message.message}
                                        </p>
                                        <span class="text-xs text-blue-200  block">${response.message.date}</span>
                                    </div>
                                </div>`
                            );
                            (`#preMessage-${auth_id}`).text(response.message.message)

                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error); // Debugging
                        alert("Error sending message!");
                    }
                });
            } else{
                alert('Enter Message')
            }
            
        });

        // Listening for New Messages

        window.Echo.private(`chat-channel.${auth_id}`)
            .listen('NewMessage', (data) => {
                console.log(data)
                if (auth_id == data.sender_id) {
                    $("#showMessage").append(`
                        <div class="flex justify-end my-1">
                            <div class="max-w-[70%] bg-blue-700 text-white rounded-lg p-2">
                                <p>${data.message}</p>
                                    <span class="text-xs text-blue-200  block">${data.date}</span>
                            </div>
                        </div>`
                    );
                    (`#preMessage-${auth_id}`).text(data.message)

                } else {
                    $("#showMessage").append(`
                        <div class="flex justify-start my-1">
                            <div class="max-w-[70%] bg-white dark:bg-gray-700 rounded-lg p-2">
                                <p class="text-gray-800 dark:text-gray-200">
                                    ${data.message}
                                </p>
                                <span class="text-xs text-blue-200  block">${data.date}</span>
                            </div>
                        </div>`
                    );
                    (`#preMessage-${auth_id}`).text(data.message)

                }
            });
    });
</script>

</html>
