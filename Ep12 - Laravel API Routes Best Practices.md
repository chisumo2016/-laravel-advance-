            ###  Laravel API Routes Best Practices

            Route::get('/users',[\App\Http\Controllers\UserController::class, 'index']);
            Route::get('/users/{user}',[\App\Http\Controllers\UserController::class, 'show']);
            Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
            Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
            Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
      
             Imagine you're buildig a giant api route like above will be mess of code,the best way is to use
            1: Create a deelicated api folder within rooutes folder .Create users.php file
                    Example:  routes/api/users.php
                    <?php
                    use Illuminate\Support\Facades\Route;

                    //Route::apiResource('users',  \App\Http\Controllers\UserController::class);
                    Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index']);
                    Route::get('/users/{user}',     [\App\Http\Controllers\UserController::class, 'show']);
                    Route::post('/users',           [\App\Http\Controllers\UserController::class, 'store']);
                    Route::patch('/users/{user}',   [\App\Http\Controllers\UserController::class, 'update']);
                    Route::delete('/users/{user}',  [\App\Http\Controllers\UserController::class, 'destroy']);

            To assess the file above inside the api.php we use 
                        require __DIR__ . '/api/users.php';

            To talk about  "Route Group "
            Syntax:

                Route::middleware('auth')->group(function (){
                    
                });
                **use Illuminate\Support\Facades\Route;

                Route::middleware('auth')->group(function (){
                Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index']);
                Route::get('/users/{user}',     [\App\Http\Controllers\UserController::class, 'show']);
                Route::post('/users',           [\App\Http\Controllers\UserController::class, 'store']);
                Route::patch('/users/{user}',   [\App\Http\Controllers\UserController::class, 'update']);
                Route::delete('/users/{user}',  [\App\Http\Controllers\UserController::class, 'destroy']);
                });
                
             we can add the prefix() to each member to our group
            Syntax: 
                         Route::middleware('auth')
                            ->prefix('test')
                            ->group(function (){
                             
                        });

            Example
                 Route::middleware('auth')
                    ->prefix('test')
                    ->group(function (){
                      Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index']);
                      Route::get('/users/{user}',     [\App\Http\Controllers\UserController::class, 'show']);
                });


            we can add name() to our route
             Syntax ;
                     Route::middleware('auth')
                            ->prefix('test')
                            ->name('users.')
                            ->group(function (){
                                      ()->name('index');
                        });

            Example
                 Route::middleware('auth')
                            ->prefix('test')
                            ->name('users.')
                            ->group(function (){
                               Route::get('/users',[\App\Http\Controllers\UserController::class, 'index'])->name('index');
                        });

                 Route::middleware('auth')
                    ->prefix('test')
                    ->name('users.')
                    ->group(function (){
                    Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index'])->name('index');
                    Route::get('/users/{user}',     [\App\Http\Controllers\UserController::class, 'show']);
                    Route::post('/users',           [\App\Http\Controllers\UserController::class, 'store']);
                    Route::patch('/users/{user}',   [\App\Http\Controllers\UserController::class, 'update']);
                    Route::delete('/users/{user}',  [\App\Http\Controllers\UserController::class, 'destroy']);
                });

             php artisan route:list  

          we need to use the namesspace method, find the controller class
            Syntax:
                    Route::middleware('auth')
                        ->prefix('test')
                        ->name('users.')
                        ->namespace("\App\Http\Controllers")
                        ->group(function (){


                   });


         we can put into an array key
            Syntax
                    Route::group([
                        'middleware' => [
                            'auth'
                        ],
                        'prefix' => 'test',
                        'as' => 'users.',
                        'namespace' => "\App\Http\Controllers",
                    ], function (){
                     //code


                    });

           Example:
                    Syntax
                    Route::group([
                        'middleware' => [
                            'auth'
                        ],
                        'prefix' => 'test',
                        'as' => 'users.',
                        'namespace' => "\App\Http\Controllers",
                    ], function (){
                      Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index'])->name('index');
                    });

        Method Syntazx or Array Syntax ? Method Synntax

      API Versioning 
            V1 and V2
        Create a folder inside the api and call V1, -move a users.php into it
        Inside the api.php file change 
                require __DIR__ . '/api/users.php';
                into require __DIR__ . '/api/V1/users.php';

        We can regroup the versioning
        Syntax:
                Route::prefix('v1')
                ->group(function (){
            
            });

       Example: 
               Route::prefix('v1')
                ->group(function (){
               require __DIR__ . '/api/V1/users.php';
            });

    If you wannt to exclude certain route with middleware , we use 
        ->withoutMiddleware('auth')

     1:  Array 

                Route::group([
                'middleware' => [
                'auth'
                ],
                'prefix' => 'test',
                'as' => 'users.',
                'namespace' => "\App\Http\Controllers",
                ], function (){
                
                    Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index'])
                        ->name('index')->withoutMiddleware('auth');
                    Route::get('/users/{user}',     [\App\Http\Controllers\UserController::class, 'show'])->name('show');
                    Route::post('/users',           [\App\Http\Controllers\UserController::class, 'store'])->name('store');
                    Route::patch('/users/{user}',   [\App\Http\Controllers\UserController::class, 'update'])->name('update');
                    Route::delete('/users/{user}',  [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
                });

    2: Method

            Route::middleware(['auth'])
            ->prefix('test')
            ->name('users.')
            ->namespace("\App\Http\Controllers")
            ->group(function (){
        
            Route::get('/users',            [\App\Http\Controllers\UserController::class, 'index'])->name('index')->withoutMiddleware('auth');;
            Route::get('/users/{user}',     [\App\Http\Controllers\UserController::class, 'show'])->name('show');
            Route::post('/users',           [\App\Http\Controllers\UserController::class, 'store'])->name('store');
            Route::patch('/users/{user}',   [\App\Http\Controllers\UserController::class, 'update'])->name('update');
            Route::delete('/users/{user}',  [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
        });


      We can add the constrainnts in the route end point
         -  pass the number only
                    where()
                    whereAlpha()
                    whereAlphaNNumeric()
                    whereNumber()
                    wheres()
                    whereUuid()
                    setWheres()

      Route group ca help uss to effectively organise our API Route.
      We can either use the array syntax  or the method syntax tpo define a routee group
      We can add URL prefix, route name prefix, namespace and middlware to route group
      The where() method is useful to add matching constrait to url parametersss.
