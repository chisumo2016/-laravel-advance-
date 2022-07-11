####  Ep37 - Laravel Fortify: Email Verification and Updating User Profile

        [X] These below are the features of Fortify
            Features::registration(),
            Features::resetPasswords(),
            Features::emailVerification(),
            Features::updateProfileInformation(),
            Features::updatePasswords(),
        [x] We the above method in config/fortify.php
        [x] php artisan route:list 
        [x] implement the interface class 
                implements MMustVerifyEmail
        [X] Test via Postman

        Fortify provides us a handy eemail verificatioon feature to confirm the user's email address.
        We can use the 'verify' middleware to protect our app routes.
        We  will need to implement the "MustVerifyEmail"  interface to our user model for email verification to work .
