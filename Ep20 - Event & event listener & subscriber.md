        #### Event & event listener & subscriber

          - When the new post has been create  we need to trigger an event
              1: Create a service class
                    we can put all the mailing logic on it and call the servicee class to our controller
              2: Event + Event Listner
                   example
                            If the task has been completed - fire UserCreated event
                                    this event will broadcasted to all app
                            Listener will send wellcom email to the  user

                  Event Listener is functionn listen to a event

        HOW TO USE THE EVENT LISTNER -  USER REPOSITORY CLASS
            The event will be implemeted inside the UserRepository class .
           
                CODE: app/Repositories/UserRepository.php
                    create() method
                    update() method
                    forceDelete() method

               TERMINAL:
                    php artisan make:event UserCreated
               app/Events/UserCreated.php
            The above class command will create a UserCreated class ,it uses few traits of the box

              TRAITS: use Dispatchable, InteractsWithSockets, SerializesModels;

           Meant to work with Ques and websocket

        The constructor accept the user model but we need to set the protected property
                protected  $user;
             
             public function __construct(User $user)
                {
                    $this->user = $user;
                }

        We need to firing up (Dispatch) this our event to the UserRepository 
            In the UserRepository class 
                    create(){
                               event(new UserCreated($UserCreated));
                            }

     LISTENER EVENT
        php artisan make:listener SendWelconeEmail
     Will create another folder caller Listener
            app/Listeners/SendWelconeEmail.php

         In handle method will define our logic when the event is dispatched,
        we need to send our welcome mssg to our user
       In UserController  index() method 
            public function index()
            {
                event(new UserCreated(User::factory()->make()));
           }

      To Link our event to our Listner
            app/Providers/EventServiceProvider.php

              protected $listen = [
                    Registered::class => [
                        SendEmailVerificationNotification::class,
                    ],
            
                    //Mapping
                     UserCreated::class =>[
                         SendWelcomeEmail::class,
                     ]
                ];

      WE NEED TO CREATE A FOLDER CALLED MODELS IN EVENTS 
            1:  app/Events/Models
            2: Insidee of Models folder create a folder called Users
                app/Events/Models/Users
            3: Move the UserCreated into the Users folder
                app/Events/Models/Users/UserCreated.php
            
     WE NEED TO CREATE  EVENTS THE FOLLOWING
            DeletedCreated
            UpdatedCreate
            php artisan make:event UpdatedCreated     
            php artisan make:event UpdatedCreated 
           
             On each we need to pass even ,should pass the user model ,initialize the protected $user;
        
     WE NEED TO REGISTER OUR DISPATCH EVENT IN USERREPOSITORY  
            update() method
                event(new UpdatedCreated($user));

            delete() method
                event(new  DeletedCreated($user));

    WE NEEED TO CREATE OUR EVENT LISTNER 
        Organise our code with Subscriber 
        we need to create a subscriber from scratch
            app -> create folder -> Subscriber
        Inside the Subscriber create Models folder
            Subscriber -> create folder -> Models
        Inside the Models create UserSubscriber class
            Will have subscriber method w/c will have Dispatcher 
                //listiner method from our dispatcher to MAP our event
              public  function  subscribe(Dispatcher $events)
                 {
                     //listiner method from our dispatcher to MAP our event
                     $events->listen(UserCreated::class, SendWelcomeEmail::class);
                 }

       WE NEED TO REGISTER OUR SUBCRIBER 
         - We reegister subscriber into EvenServiceProvider
                protected  $subscribe = [
                UserSubscriber::class
            ];

       REMEMBER : comment out the  Mapping inside the EventServiceProvider
            //Mapping
                 /*UserCreated::class =>[
                     SendWelcomeEmail::class,
                 ]*/

      TEST OUR CODE VIA POSTMAN
        GET : http://laravel-advance.test/api/v1/test/users
       
      NB: WE USE THE SUBRIBER IF WE BUILD LARGE APPLICATION , UNLESS USE EVENT ON SMALL APPLICATION.

     USE THE SAME TECHNIQUES ON POST AND COMMENT TO IMPLEMENT  EVENTS
        EXERCISE:
                1:  POST
                2:  COMMENT



    Event listeners are classes / functions that get exeecuted whenn an event is dispatched
    We defined our Event - Event Listener mapping in the EVENT SEERVICE PROVIDER
    Event Subscriber is a class that let us to group our event - listner mappings in one place.
    We register Subsribers  in the $subscribeer property fron the EVENT SERVICE PROVIDER .
    
