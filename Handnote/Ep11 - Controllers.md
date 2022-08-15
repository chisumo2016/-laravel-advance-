        ###  Controllers
              We can inject our dependecy in controller
                Auto Binding Resolution
                    Route::get('/users/{user}', function (Request $request, \App\Models\User $user){
                        dump($request);
                        return new \Illuminate\Http\JsonResponse([
                            'data' => $user
                        ]);
                    });
      
        Create a UserController 
            php artisan make:controller UserController --resource --model=User  

            Route::get('/users',[\App\Http\Controllers\UserController::class, 'index']);
            Route::get('/users/{user}',[\App\Http\Controllers\UserController::class, 'show']);
            Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
            Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
            Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);

         The above route isnt much cleaner , we need to use a Resoure() HELPER METHOD;
                    Route::resource('users',  \App\Http\Controllers\UserController::class);
         php artisan route:list   
            To avoid the other extra method like create , edit (form ) - use apiResource()

        Conroller is function that runs when a HTTP request hits a route
        We can deletegate our route controllers into a dedicated Laravel Controller class

        There are 5 main methods in a controller class
                Index - display a list of resources .
                Store - create a new resources .
                Show - display  a specific resource .
                Update - update a specific  resource .
                Destroy -  deletes a specific resource resources.
      
       The resource route helper method enables us to easily define API routes
