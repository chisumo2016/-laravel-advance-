###  Authentication with Laravel Fortify: An Overview
    
        [X]  Fortify and Authentication introduction 
        [X]  Authentication introduction is very importannt to a typical apps
        [X]  We gonna use Fortify which takes care with authentication
                STEPS:
                        1: composer require laravel/fortify
                        2: php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
                        3: php artisan migrate
        [X] You should ensure this class is registered within the providers array of your application's config/app.php configuration file.
              PATH:  config/app.php
              LOAD : \App\Providers\FortifyServiceProvider::class,
        [X] FortifyServiceProvider Will register all relevant actions for us   ,inside boot()  
        [X] config/fortify.php

        Laravel Fortify is a package that takes care of most authenticatioon logic for us .
        Laravel Fortify provides us several features out of the box , Example.
                    1: Registration
                    2: Login
                    3: Reset password
                    4: Email verification
                    5: Update Profile Information .
                    6: Update Password
                    7: 2 Factor Authentication
        [X] You don't have to implement these features from scratch .
