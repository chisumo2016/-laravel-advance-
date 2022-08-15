###   Laravel Fortify: Auth, Registration and Password Reset

        [X] Fortify : Authenntication Registration and Password Reset .
        [X] These below are the features of Fortify
                Features::registration(),
            Features::resetPasswords(),
            // Features::emailVerification(),
            Features::updateProfileInformation(),
            Features::updatePasswords(),
            Features::twoFactorAuthentication([])
        [X] Run the route list command
                php artisan route:list -c
        [X] Run the db:seed command
                php artisan db:seed
        [X] CSR Token
              Joe ----------Login ------->Bank App -------------Session,
              < ----reponse+Cookie -------Bank App -------------Session,
              --------------cookie + CSRF token-------->Bank App ----------- Session
       [X] To test our login API point 
            TEST: http://laravel-advance.test/login
            RESULT: Fail
            SOLN: Miss Match
       [X] To resolve this problem , to install Laravel Sanctum .
             DOC: https://laravel.com/docs/9.x/sanctum
      [x] You need to disable the VerifyCsrfToken: in      app/Http/Kernel.php

       Laravel protects alll its web route froM  CSRF attacks by default .
       We nneed Laravel Santum if we wannt to proyects our API routes from CSRF attackss.
       We can Fortity Action classes to customize the user registration logic alonng with other actions .
       Passwort Reset requires GET route with a route name of 'password.reset' in order top work properly .
