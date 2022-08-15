      ###  RESTful API Route Design and Laravel Routes
                    https://restfulapi.net/rest-architectural-constraints/
                    api       we put our api 
                    channel   we put our socket channel
                    consolee  simple artisan command
                    web        page

            Desiging Api  in popular way :
                    REST
                    Graphql

        RESTFUL API
        GET         Reading data    
                    /users
                    /users/{id}

        POST        Creating data 
                    /users

        PATCH/PUT   Update data
                     /users/{id}

        DELETE      Delete data
                         /users/{id}

               Route::get('/users', function (){
                return new \Illuminate\Http\JsonResponse([
                'data' => 'aaasss'
                ]);
                });

            Dump all the object from the request

                Route::get('/users', function (Request $request){
                    dump($request);

                return new \Illuminate\Http\JsonResponse([
                'data' => 'aaasss'
                ]);
                });

           Specific id 
            Route::get('/users/{id}', function ($id){
                return new \Illuminate\Http\JsonResponse([
                    'data' => $id
                ]);
            });

       Implicit Binding
            Route::get('/users/{$user}', function (\App\Models\User $user){
                return new \Illuminate\Http\JsonResponse([
                    'data' => $user
                ]);
            });

       Explicit  Binding - RouteServiceProvider.php
        Route::bind('user', function ($value){
            return 123;
        });

      ======================================================
                  Route::get('/users/{$user}', function (\App\Models\User $user){
                return new \Illuminate\Http\JsonResponse([
                    'data' => $user
                ]);
            });
            
            
            Route::post('/user', function (){
            return new \Illuminate\Http\JsonResponse([
            'data' => 'posted'
            ]);
            
            });
            
            
            Route::patch('/user/{user}', function (\App\Models\User $user){
            return new \Illuminate\Http\JsonResponse([
            'data' => "patched"
            ]);
            
            });
            
            
            oute::delete('/user/{user}', function (\App\Models\User $user){
            
                return new \Illuminate\Http\JsonResponse([
                    'data' => "deleted"
                ]);
            });


     API routes typically refers to routes that return JSON ,while web routes are routes that
            return HTML pages

     We define API routess in the api.php file , and web routes in web.php
     Laravel uses the 'substitute bindings middleware ' to automatically load model
      instance too the controller .
