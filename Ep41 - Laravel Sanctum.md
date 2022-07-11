### Laravel Sanctum
     Web: https://laravel.com/docs/9.x/sanctum
    [X] fotify isn't enough .Doesnt provide these below feeatures out of the box .
    [X] They use token or cookies
    [X] Laravel provide to packages to generate the above.
            1: Passport 
                Is designed for enterprize application
            1: Sanctum
                Is designed for simple application
    
    [X]Sanctum provide two ways to authentoicate.
            1: API Token 
                        client ----request (headeer)--------->server
            2: Cookie 
                    client ----request (headeer)--------->server
                    client <----request + cookie----------server
                    client ----request + login------------>server
                    client ----cookie--------->server
            [X] Stateful  Authorization 
            [X] API is simple ad risky
            [X] If someonne steal a tokeen can act like you .
            [X] Cookie is more ssecure that Sanctum
            [X] Cookie is hard to setup
            [X] Sanctum uses web guards
            [X] We can setup CSRF and XSS
            [X] It's complicated
            [X] Setup Sanctum 
                    composer require laravel/sanctum
                    php artisan vendor:publish and select 
                OR php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
                    php artisan migrate 
            [X] uncommet  \App\Http\Middleware\VerifyCsrfToken::class, inside app/Http/Kernel.php
                    'api' => [
                        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                        'throttle:api',
                        \Illuminate\Routing\Middleware\SubstituteBindings::class,
                    ],
            [X] To configure the env file ,change the session driver .
                        FROM: SESSION_DRIVER=file
                        TO:   SESSION_DRIVER=cookie
                              SESSION_DOMAIN=".http://laravel-advance.test"
                              SANCTUM_STATEFUL_DOMAINS="127.0.0.1:8000,.http://laravel-advance.test"
                Laravel will store in the form oof cookiee
            [X] Let us go to our api routs
            [X] Sanctum is the middleware to protect our routes
                    ->middleware([
                        'auth:sanctum'
                        'auth:sanctum'
                    ])
           [X] Create a file app.blade.php , and write javascript code 
           [X] Test the application to viee the token
                    http://laravel-advance.test/app
           [X] The journey of stateful starts here .
                    Set-Cookie: XSRF-TOKEN
          [X] To view the cookie you need to -->inspect ->network and applicattion
          [X] CORS ERRORS ->Cors file we need to setup "supports_credentials' => true,


     Sanctum offer cookie-based authenticatio and token-based authenntication .
     Token is simple to setup abnd use but can bee dangerous if it is stolen .
     Cookie is harder to setup, but it will protect our app from CSRF and XSS attacks .
     Cookie based authentication is sennsitive to domain names , be sure to configure Sannctum before use .
