### Throttle Middleware and Rate limiting
    [X] Throttle Middleware 
         Throttlee - To limit the number of request ,that are allowed in period of a  time .Eg web server 60min
    [X] Give us good protection with this attack vs DOS
    [X] Lives in this folder app/Http/Kernel.php
            'api' => [
            'throttle:api'
            'throttle:60, 1'
           ],
    [X] Throttle middleware is mapping into  ThrottleRequests class
            protected $routeMiddleware = [
                'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            ];
    [X] Passing the api arguments into throttle middlware class
    [X] It defines in the app/Providers/RouteServiceProvider.php via configureRateLimiting method
            Example: Limit::perMinute(60)
    
     Throtte means to limit number of operations in a given period of time .
     The throtle middlware i Laravel hepls to mitigate Denial of Service (DoS) attacks from malicious user.
     We can define name Rate Limiter in Route Service Provide .
     We can pass in the rate limiting config directly to the throtle middleware if we prefer not to use the 
        named Ratee Limiter .
