### Private and Presence Channels
    [X] Authorize the user too join the user .
    [X] Change the broadcastOn to use the PrivateChannel.
            app/Events/ChatMessageEvent.php
    [X] We need to authorize the channel
                routes/channels.php
                resources/js/app.js
    [X] Test the application
          http://laravel-advance.test/ws
    [X] Login before subscribing 


    # table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
