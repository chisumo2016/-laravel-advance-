  ##  Sending email 
       To send a welcome email when the new user has been created .
       We can  use the command to create a mail class
            php artisan make:mail WelcomeMail
                FOLDER: app/Mail/WelcomeMail.php
      purpose is to define the email it self inside the mail class:
                Template
                Title
                Data
     
        Build method show us to to createe our email , resulting the result oof view method,
        View function is the finction to returnn the view from Views FOlder.
        Create folder called mail inside the Views folder
        We put everything related to mail to this folder.Create welcome-mail template
            resources/views/mail/welcome-mail.blade.php
        Go back to the welcomeMail class ---> inside the build method 
                 public function build()
                    {
                        return $this->view('view.name');
                    }
         change into 
                public function build()
                {
                    return $this->view('mail.welcome-mail');
                }
        render() will return the represantation html for our email .
     TEST OUR EMAIL :
                if (\Illuminate\Support\Facades\App::environment('local')){
                Route::get('/playground', function () {
                    return (new \App\Mail\WelcomeMail())->render();
                });
            }
    NB : Laravel provide a way to write our email via MARKDOOWN, Nice way to write email template
       We need to pass the our markdown into mail class
        public function build()
            {
                return $this->view('mail.welcome-mail');
            }

        public function build()
            {
                return $this->markdown('mail.welcome-mail');
            }

       Write the Markdown  in the welcome-mail.php
                 @component("mail::message")

                    # Welcome !!
            
                    Thanks, <br>
                    Blogpost
            
                @endcomponent

       TEST OUR EMAIL :
                if (\Illuminate\Support\Facades\App::environment('local')){
                Route::get('/playground', function () {
                    return (new \App\Mail\WelcomeMail())->render();
                });
            }
     To remove the laravel Logo from env file
        APP_NAME=Blogpost
    To change the style of our template , we can use the vendor
        php artisan vendor:publish 
    Select laravel- mail tag  we can customize 
    To make our mail class to accept the user model in the constructor 
                private  $user;

               public function __construct(User $user)
                {
                    $this->user = $user;
                }
    Then to acceess the name we need to pass  # Welcome {{ $name }}!! in Markdown

    To Test in web file
                if (\Illuminate\Support\Facades\App::environment('local')){
                    Route::get('/playground', function () {
                        return (new \App\Mail\WelcomeMail(\App\Models\User::factory()->make()))->render();
                    });
                }
    
    How can we send the email using laravel
        STEPS:
                Fake STMP Server   (https://mailtrap.io/)
                Pass the creditial into evn 
                Send email we can use email facadees inn web file
                    if (\Illuminate\Support\Facades\App::environment('local')){
                        Route::get('/playground', function () {
                           $user = \App\Models\User::factory()->make();
                            \Illuminate\Support\Facades\Mail::to($user)
                                ->send(new \App\Mail\WelcomeMail($user));
                            return null;
                        });
                    }
                Go back to Mail class add some property

                        public function build()
                        {
                            return $this
                                ->subject('Welcome to Blogpost')
                                ->markdown('mail.welcome-mail', [
                                /** Array to pass into the view*/
                                'name' => $this->user->name
                            ]);
                        }
                We need to add the ap_name to our markdow template
                                {{ config('app.name') }}

                We need to send an email when the new user has been recreated via Event Listner.
                  app/Listeners/SendWelcomeEmail.php
                         public function handle($event)
                            {
                                Mail::to($event->user)->send(new WelcomeMail($event->user));
                            }
                  In the user event app/Events/Models/User/UserCreated.php
                            to change the property into public
                                public  $user;


        Laravel Mail class offers us an easy way to define and send out application emails .
        Mailtrap.io is a fake STMP testing service that allow us to test email in our local environment .
        Laravel allows us to write our mail template i markdown syntax .
        We can use the Mail facade to send out email.









