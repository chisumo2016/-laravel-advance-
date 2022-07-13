### Notifications with Laravel
    [X] Notification today to all apps . eg facebook,instagram ,icon or email
    [X] Laravel provide a way to send a notifications to our user .
    [X] Create a notification class  .
            php artisan make:notification PostSharedNotification
    [X] The above code will create app/Notifications/PostSharedNotification.php class
            traits
            constructor
            toMail
            toArray
    [X] Sending notification is very expensive ,especially in the form  of email .
    [X] If you send synchronizely it will be blocked .
    [X] Laravel provide a Queueable trait , 
    [X] In order for  Queueable trait to work we should implements the ShouldQueue, 
                implements  ShouldQueue
    [X] via method , provide the way we should sennd our chanbel
            Mail  send a email to user ,
            Database  send to our local databsee,user will see in front end
            broadcasee send via javasctipt in real  time via web socket.
            vonage  send the sms to our user
            slack  popular sending message
       $notifiable - user
    [X] Pass the injection into constructor 
    [X] Makee the property as private.
    [X] Pass the property into  toMail($notifiable)
    [X] In order for notification to work ,go to share() method in PostCoontroller
    [X] Two way to send a notification with Laravel
            1:Use Notication Facades
                $users = User::query()->whereIn('id',$request->user_ids)->get();
                Notification::send($users, new PostSharedNotification($post, $url));

            2:To call the notified function on user instance
                $user = User::query()->find(1);
                $user->notify(new PostSharedNotification($post, $url));

    [X] Make our user model notifiable
    [X] Notification facedes accept two parameters:
                Notification::send(ARRAY OF USER MODEL, INSTANCE OF NOTIFICATION);
            
                new PostSharedNotification(CONSTRUCTOR , $url)
    [X] Disable the middlware
    [X] Test the application via Insomnia rather than postman
            http://laravel-advance.test/api/v1/test/posts/1/share

    Laravel provides us a variety of drivers to ssend out notifications to our users,including 
        Mail , Databases, Broadcast, slack and Vonage .
    There aree many more community maintained drivers, eg telegram , discord
    Php artisan make:notification will generate the boilerplate to create a nnew notification class.
    We can use Notification::send() or $notifiablee->notify() to send out notifications .
    
