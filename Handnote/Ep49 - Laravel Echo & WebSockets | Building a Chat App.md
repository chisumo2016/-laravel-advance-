###  Laravel Echo & WebSockets | Building a Chat App

     [X] Subsribe on the  frontend of javascript, USE laravel echo
     [X] We nneed to install  laravel Echo
            npm install laravel-echo pusher-js

     [X] We need to configure webpack/vite
                 php artisan websockets:serve
                 npm run  build  

     Echo is the official client js library for us to subscribe and receive websocket events from the server .
     Laravel mix is womderful wrapper around webpack that provides a painless API for us to configure webpack .
     Echo.channel() allows us to subscribe toa websocket channel .
     Echo.subscribed() lets us to define a callback that will be triggered when we havee successfully subscribed to a channel .
     We  use listen() to listen to websocket events.
     We should use a '.' prefix when we want to listen to custom event echo.
