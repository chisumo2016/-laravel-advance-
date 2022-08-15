### Ep48 - Broadcasting Events and Websocket Channels | Laravel API Server
    [X] Broadcasting and Channelsss
       Laravel require as to broadcast this events via channel.
    [X] Three types of channels in Laravel ,if the websocket want to connect
                1:Public   
                    Doesn't need the authentication
                1:Presence
                    Do need the authentication
                    User knows each other
                            chat messagee
                1:Private
                    Do need the authentication
                    User don't know each other.
    [X] Config the channel, uncomment  App\Providers\BroadcastServiceProvider::class, in  
            config/app.php              
            routes/channels.php          
           
            CLIENT   --------HTTP-------->SERVER   auth endpoint ->channel.php
                    <---------RES-------->
                    <---------WS--------->
    [X] Create a dummy events
            php artisan make:event PlayGroundEvent
    [x] To make this class broadcastable, we should  implemennts ShouldBroadcast interface
           class PlayGroundEvent implements  ShouldBroadcast
            {}
    [X] PrivateChannel() we define w/ch websocket we would like to broadcast .
          Pusher error: auth_key should be a valid app key

    If a clients wants to subscribe to a websocket chanel inn Laravel, the client will first perform a 
        "HTTP handshake" ie to authennticate the user before establishing a persisted websocket conection .
    Event classess will need to implement the ShouldBroadcast interface before Laravel can broadcast them to the WS.
    We need to configure the host and port oof the Pusher driver in broadcasting.php config file to get Laravel
      to use our self-hosted Laravel Websocket Server.
    By default, Laravel will use the Eveennt FQCN as the event name.We can customize this by definingf broadcastAs() .
    BroadcastWith() is a way for us to attach data inn the event payload.
