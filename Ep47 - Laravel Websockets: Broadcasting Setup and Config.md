### Laravel Websockets: Broadcasting Setup and Config
         [X] Types of webssockets
                    1: Pusher Websockets Service
                            https://pusher.com/
                    2: Ably Websocket Service
                            https://ably.com/
                    3: Laravel Websocket
                            https://beyondco.de/docs/laravel-websockets/getting-started/introduction
                    4: Laravel Echo Server
                            https://github.com/tlaverdure/laravel-echo-server
                    5: Soketi
                            https://github.com/soketi/soketi
         [X] For client side, laravel provide echo
         [X] Websocket  Installation
                    composer require beyondcode/laravel-websockets
                     php artisan vendor:publish   
                    php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
                    composer require pusher/pusher-php-server
         [X] let us looke the config/websockets files
                multitenancy achitecture
         [X] Install the pushe package 
                composer require pusher/pusher-php-server
         [X] We need to configure pusher
         [X] Driven by event
                New Event ---------WS Server-------->Broadcast -->Client
                This process is time consuming .
                We can use the Queu to send a job .
                Driver available
                    Redis  driver
                    Sync  driver ,this will provide the job synchrozinelly no quee
                    Laravel will send the job directly to the server
         [X] To setup the Sync driver
                QUEUE_CONNECTION=sync
         [X] Enable service provider   Illuminate\Broadcasting\BroadcastServiceProvider::class,
                config/app.php
         [x] To test our web socket
                php artisan  
                    websockets
                    websockets:clean       Clean up old statistics from the websocket log.
                    websockets:restart     Restart the Laravel WebSocket Server
                    websockets:serve       Start the Laravel WebSocket Server

                Access Via http://laravel-advance.test/laravel-websockets
         
           Pusher ,Ably ,Laravel websockets , Soketi and Laravel Echo Server are weebsocket server that are
                supported by Laravel.
           Laravl Websockets is a wondeerful openn source drop-in replacement for Pusher.   
           Laravel uses thee PubSub weebsocket pattern to publish real-time app Events.
           We need to setup a queue driver for Laravel to broadcast websocket events.
           The BroadcastServiceProvider should be enabled in the app config.
           Laravel Weebsockets exposed a debuggiing dashboard for our websocket connection.
