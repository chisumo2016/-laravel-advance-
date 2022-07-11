###   Laravel Fortify: 2 Factor Authentication | Laravel API Server
        [X] Run the php artisan list
                php artisan route:list
       [X]View all the routes vendor/laravel/fortify/routes/routes.php
       [X] Test all our endpoint via Postma .

            The  User Model needs to use the TwoFactorAuthenticatable trait in order for 2FA to work properly .
            The confirmPassword option will force the user to confirm their password when setting up 2FA
            Laravel will issue the user a nnew set of recovery codes if they log in via recovery code .
