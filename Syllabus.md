        Timestamps:
          https://www.youtube.com/watch?v=_zNi37BJVBk SAM

            https://www.codewithharry.com/videos/tailwind-course-in-hindi-1/ TAILWINDCSS

        00:02 Ep01 - Laravel's Architecture: A quick Overview | Directory and App Structure
        10:04 Ep02 - Middleware and Http Kernel
        19:17 Ep03 - Service Container and Service Provider
        29:18 Ep04 - Facade
                        Allows us to call Service Instance meethod statically , providing us a convenient way to ccall Service method.
                        You can think oof Facade as the static counterpart of a Servoce Class
                            https://laravel.com/docs/9.x/facades#:~:text=In%20a%20Laravel%20application%2C%20a,Support%5CFacades%5CFacade%20class.
        33:12 Ep05 - App overview
                        Front End
                        Backend End
        36:11 Ep06 - Database Design and Migration | Laravel API Server
                        Entity Relationship Diagram (ERD)
                        draw.io
                        Database Engine:
                                sequal Pro
                                https://alvarotrigo.com/blog/mac-database-software/
                        php artisan
                        php artisan make:model --help
                        php artisan make:model Post -a
                        php artisan make:model Post -a --api
                        php artisan make:model Comment -a --api
                        php artisan make:migration create_post_user_table --create=post_user
                Migration is a cconcept of version control for database;
                Laravel will run mmigration files in chronological order, ie by following the
                 timestamp in the migration file name .
                The artisan console is a wondeerful tool to generate boilerplate for our project

        50:24 Ep07 - Seed and Factories | Laravel API Server
                        php artisan make:seeder UserSeedeer 
                        php artisan db:seed
                        php artisan migrate:fresh --seed   
                 
                Goes in the Seeder class of each class
                      Disable Check of FK
                 DB::statement('SET FOREIGN_KEY_CHECKS= 0');
                 DB::table('users')->truncate();
                ---------CODE-----

                  Unable Check of FK
                 DB::statement('SET FOREIGN_KEY_CHECKS= 1');

           Create a folder Called Traits -> seeders Folder -> Class ->TruncateTable.php
           Call the truncateTable Trait inside the UserSeeder.php
                use TruncateTable;
                
          Create a folder Called Traits -> seeders Folder -> Class -> DisableForeignKeys.php
          Call the DisableForeignKeys Trait inside the UserSeeder.php
                use DisableForeignKeys;
         
         Override our title
                Post::factory(3)->create();
                Post::factory(3)->state(['title' => 'untitled'])->create();
                
                 php artisan db:seed    

        Or we can create this state in PostFactory class
                 public  function  untitled()
                    {
                        return $this->state(['title' => 'untitled']);
                    }
          use it inside the PostSeeder,call the untitled method
                Post::factory(3)->state(['title' => 'untitled'])->create();
                Post::factory(3)->untitled()->create();

        Seeding is referred to populating the datbase with dummy data
        Factory classes are used to generate fake models
        We put the main seeding logic in the classed called Seeder
        We cann use the db:seed Artisann command to trigger the seeders.


        1:04:03 Ep08 - All about models and relationships
              One To Many Relationship
                Consider to factors 
                        Parent    Post
                        Child     Comments
                Post has many Comments
                        Child Comments has the FK
                Post Model
               public  function  comments()
            {
                return $this->hasMany(
                   related:   Comment::class,
                   foreignKey: 'post_id'
                );
            }
       $this represeents Post Model
      
        Test Our Model 
                php artisan tinker
                    \App\Models\Post::find(1)->comments   
                        ->comments is magic property we called in post Model relationship
    
       Inverse in Comment Model
          public  function  post()
            {
                return $this->belongsTo(
                    related: Post::class,
                    foreignKey: 'post_id'
                );
            }

      Test Our Model 
                php artisan tinker
                 \App\Models\Comment::find(1)->post;

    
      User and Comment Relationship
       
       public  function  comments()
        {
            return $this->hasMany(
                related:   Comment::class,
                foreignKey: 'post_id'
            );
        }

       Test Our Model 
                php artisan tinker
                    \App\Models\User::find(1)->comments
                        ->comments is magic property we called in post Model relationship


      Inverse in Comment Model
          public  function  user()
            {
                return $this->belongsTo(
                    related: User::class,
                    foreignKey: 'user_id'
                );
            }

      Test Our Model 
                php artisan tinker
                 \App\Models\Comment::find(1)->user;


     Many To Many Relationships

      Post Model Class
           public  function  users()
            {
                return $this->belongsToMany(
                    related: User::class,
                    table: 'post_user',
                    foreignPivotKey: 'post_id',
                    relatedPivotKey: 'user_id'
                );
            }

      User Model Class

        public  function  posts()
            {
                return $this->belongsToMany(
                    related:        Post::class,
                    table:          'post_user',
                    foreignPivotKey: 'user_id',
                    relatedPivotKey: 'post_id'
                );
            }


     Test Our Many To Many Relationship using Tinker
        assign the user to post id 1
      php artisan tinker
            $user = \App\Models\User::find(1);

      Assign  the user to post
          $relation = $user->posts();
          $relation->attach(1);
          $relation->attach([2,3]);
                
     Delete we use detach(post)
         $relation->detach(1);

     We can use toggle() methods
        $relation->toggle(1);
            The post 1 will toggled
    
     we can use sync , attach all relation
            $relation->sync([1,2]);

    we can use syncWithoutDetaching()
            $relation->syncWithoutDetaching([3]);

    Mutator 
     Is the function which allow to transform our model attributes
             Accessor   Read and transform values from database;
                Syntax:
                        public  function  getTitleUpperCaseAttribute()
                        {
                            return strtoupper($this->title);
                        }


              Test
                    php artisan tinker

                    >>> \App\Models\Post::find(1)->title_upper_case;

            Mutator    Transform value before we store  into database

            public  function  setTitleAttribute($value)
            {
              $this->attributes['title'] = strtolower($value);
            }

           Test
                    php artisan tinker

                    $post = \App\Models\Post::find(1);
                    $post->title = "HEYYAAA";
                     $post;

                Summary 
                Mutator
                Accessor
                Relationship
                Casting
        Accessor and Mutators transform values when we retrieve/set model attributes


        1:17:19 Ep09 - Seeding relationships
                Implemennt to our factory
                        
                        Get model count  (sstore in computer memory)
                        Generate random number btn 1 and model count
                    
                        if model count is 0 , 
                        we should create a new record and retrieve the record id

                        Get all model records
                        Randomly get one of the records , and get the id

         code:
                        /** Get model count **/
                        $count = Post::query()->count();
                
                        /** if model count is 0  **/
                        if ($count === 0){
                            /** we should create a new record and retrieve the record id**/
                            $postId = Post::factory()->create()->id;
                        }else{
                            /** Generate random number between 1 annd model count **/
                            $postId = rand(1,$count);
                        }
        
        The above code has some issue , cant suite model , The only solution is to create a 
        helper  class  within the factories folder
                    Folder: database/factories/Helpers/FactoryHelper.php
                 
                   use Illuminate\Database\Eloquent\Factories\HasFactory;
                                     /**
                     * @param string | HasFactory $model
                     * This function will get the random Id from database
                     */
                    public  static  function  getRandomModelId(string $model)
                {
                /** Get model count **/
                $count = $model::$model()->count();
                
                      /** if model count is 0  **/
                      if ($count === 0){
                
                          /** we should create a new record and retrieve the record id**/
                          return $model::factory()->create()->id;
                          
                      }else{
                          /** Generate random number between 1 annd model count **/
                          return rand(1,$count);
                      }
                }
                }

       Post Seeder we can use has()
                Post::factory(3)
                   ->has(Comment::factory(3),'comments')
                    ->untitled()->create();
      Comment Seeder we can use for()
                     Comment::factory(3)
           ->for(Post::factory(1),'post')
            ->create();

     NB:I recommennd not oo use .  Leave as it iis 

     To seed the Manny To Manny between Post and User
               $posts = Post::factory(3)->untitled()->create(); //collection

                /**Many to Many Post & User*/
                $posts->each(function (Post $post){
                  $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
                });

      NB:
        Laravel offers us factory helpers functions like has() and for() to quickly  gennerate relations
            for our models

       We can use the sync() method to generate many to many relation records .
                /**Many to Many Post & User*/
                $posts->each(function (Post $post){
                  $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
                });



        1:26:14 Ep10 - RESTful API Route Design and Laravel Routes
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


        1:39:35 Ep11 - Controllers
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
         
        1:47:22 Ep12 - Laravel API Routes Best Practices

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


        1:59:56 Ep13 - Recursively load PHP files in a directory
             Automatically Load Files Recursively
            Automatically Load Files Recursively via iterator

               Route::prefix('v1')
                ->group(function (){
                  require __DIR__ . '/api/v1/users.php';
                  require __DIR__ . '/api/v1/posts.php';
                  require __DIR__ . '/api/v1/comments.php';
            });

     The above code if it grow bigger will bee mess, solution is 
            Iterate through the v1 foldeer recursively
            $dirIterator = new RecursiveDirectoryIterator(__DIR__ . '/api/v1');
            Require the file in each iteration

     BETTER WAY:

            Route::prefix('v1')
                ->group(function (){
            
                     $dirIterator = new RecursiveDirectoryIterator(__DIR__ . '/api/v1');
            
                     /** @var  RecursiveDirectoryIterator | RecursiveIteratorIterator $it */
                     $it = new RecursiveIteratorIterator($dirIterator);
            
                     while ($it->valid() ){
                         /** Check*/
                         if(!$it->isDot()
                             && $it->isFile()
                             && $it->isReadable()
                             && $it->current()->getExtension() === 'php')
                         {
                             /** return file path 2 WAYS*/
                             require $it->key();//SIMPLE
                             //require $it->current()->getPathname();
                         }
                        $it->next();
                     }
                 /* require __DIR__ . '/api/v1/users.php';
                  require __DIR__ . '/api/v1/posts.php';
                  require __DIR__ . '/api/v1/comments.php';*/
            });
       
     We need top create a Helpers Routes
        create a app->Helper -> Routes
                app/Helpers/Routes/RouteHelper.php
         We copy our code which we have written in api.php into the RouteHelper method

            public  static  function  includeRouteFiles(string $folder)
            {
                
             }

        To ACCESS the includeRouteFiles(string $folder) into the api.php 
                \App\Helpers\Routes\RouteHelper::includeRouteFiles(__DIR__ .'/api/v1');

       Iterator is an object that allows us to iterate through a series of items .
       The directory iterator can helps us to automatically load our routes in folder


        2:05:36 Ep14 - Essential Eloquent Methods & Properties

                Implement our Logic to this controllers  - PostController
                Use Eloquent ORM to query our database
            
                1: Index Method

                    public function index()
                {
                     $posts = Post::query()->get();
            
                     return  new JsonResponse([
                         'data' => $posts
                     ]);
                }
               To Test our end point via postman
                   GET:  http://laravel-advance.test/api/v1/test/posts
    
               2: store Method

                 public function store(StorePostRequest $request)
                    {
                        //Post::query()->create($request->toArray()); never trust the user input 
                        
                        $postCreated = Post::query()->create([
                            'title' => $request->title,
                            'body'  => $request->body
                        ]);
                
                        return  new JsonResponse([
                            'data' => $postCreated
                        ]);
                    }

            Test Our Model via PostMan
                POST :  http://laravel-advance.test/api/v1/test/posts/
                Body  :  x-www-form-urlencoded
                        KEY               VALUE
                        title               test our createe
                        body                ""
               Headers:
                       KEY                  VALUE
                        Content-Type        application/json

           MASS ASSIGMENT  EXCEPTION
             Add the $fillable property in post model, never trust user iput 
                 protected  $fillable = [
                    'title',
                    'body'
                ];

          3: Show Method
                 public function show(Post $post)
                    {
                        return  new JsonResponse([
                            'data' =>$post
                        ]);
                    }
            Test via Post Man
                GET :  http://laravel-advance.test/api/v1/test/posts/1

        3: Update  Method
                We need to update the field which has been supplied by user

                public function update(UpdatePostRequest $request, Post $post)
                    {
                        //$post->update($request->only(['title', 'body']));
                
                            //Explicit Array
                        $updatePost = $post->update([
                            'title' => $request->title ?? $post->title,
                            'body' => $request->body  ?? $post->body,
                        ]);
                
                       if (!$updatePost){
                           return  new JsonResponse([
                               'errors' => [
                                   'Failed to updated the record model'
                               ]
                           ], 400);
                       }
                
                       return  new  JsonResponse([
                           'data' => $post
                       ]);
                
                    }

            Test Our Model via PostMan
                PATCH :  http://laravel-advance.test/api/v1/test/posts/1
                Body  :  x-www-form-urlencoded
                        KEY               VALUE
                        title               Update title
                        body                ""
               Headers:
                       KEY                  VALUE
                        Content-Type        application/json

           4: Destroy our Data 

                    public function destroy(Post $post)
                    {
                        $deletedPost = $post->forceDelete();
                
                        if (!$deletedPost){
                            return  new JsonResponse([
                                'errors' => [
                                    'Could not delete the record'
                                ]
                            ], 400);
                        }
                
                        return  new  JsonResponse([
                            'data' => 'success'
                        ]);
                    }

          Test our Code in Postman
                DELETE : http://laravel-advance.test/api/v1/test/posts/4

          You can appends the attribute to an api json in post model

                 protected  $appends = [
                    'title_upper_case'
                ];

                protected  $appends = [
                    'title_upper_case'
                ];
                
                protected  $hidden = ['title'];
                protected  $guarded = [];

       Laravel ORM - eloquent provides an easy API for us to work with database
        We use the query method to start a database query, get() to retrieve records,
          find() to find by id create() to insert record, update() to update annd delete() to detele .

       Laravel protects the model fields from mass assigmennt by default. To enable mass assigment, we
        will need to define the $fillable property in the model .

        $hidden will hide model fields whenn we convert the model into an array , and $append will add 
        extra fields to the array.


        2:16:18 Ep15 - DB Transaction
             Runnning multiple operation 
                    op1  - create new user 
                    op2  - create new post
                    op3 - create new comment
                         op1->op2 ------>FK
                         op2->op3 ------>FK
            Put all in DB Transaction
            If one fail, the transaction will try to rollback

        Example in PostController store()
           /** creating a record into post  table*/
            $updatePost = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body  ?? $post->body,
        ]);
            /** Associate with a user inserting record into pivot table (Post - User)*/
        $updatePost->users()->sync($request->user_ids); 

        Synntax:
           DB::transaction(() () use ($request){
                
           })


     Test an API via Postman
     Body 
            raw
            {
                "title":"Wlaaaaaa",
                "body" : [],
                "user_ids": [1,2]
            }


     Database Transaction groups multiple database operations together and only applies the 
        operations when all of them passed . It will rollback annt changes if one of the operations failed .

    We use transaction() method in the DB facade to trigger a transaction .
                  $postCreated = DB::transaction(function () use ($request){

                    $postCreated = Post::query()->create([
                        'title' => $request->title,
                        'body'  => $request->body
                    ]);
        
                    /** Associate with a user into pivot table*/
                    $postCreated->users()->sync($request->user_ids);
        
                    return $postCreated;
        
                });
                return  new JsonResponse([
                    'data' => $postCreated
                ]);


        2:20:00 Ep16 - Laravel Resource Class | API Resource | Robust API Response
        Link: https://laravel.com/docs/9.x/eloquent-resources

            If  we have many fields in the PostController , our JsonResponse will be mess.

                  return  new JsonResponse([
                     'data' => $posts
                 ]);

           The solution of above is to use the resource class
            Command to create resource class
                 php artisan make:resource  PostResource

                        public function toArray($request)
                            {
                                return [
                                    'id'    => $this->id,
                                    'title' => $this->title,
                                    'body'  => $this->body,
                                ];
                            }

           In show() of PostConntroller
                 public function show(Post $post)
                    {
                        return  new JsonResponse([
                            'data' =>$post
                        ]);
                    }
                  Convert into this 

                    public function show(Post $post)
                    {
                         return  new PostResource($post);
                    }
           NB: Repeat the all Process to the rest of controllers
            
            Resource class helos us to manage our API JSON response in one place
            It makes our API response to be more consistent and maintainable .
            We can use php artisan make:resource command to generate the resource boilerplate


        2:24:49 Ep17 - Pagination
              Paginate the API Resource 
                Example in PostController in index() we can introduce pagination in Json Response

                 public function index()
                    {
                         $posts = Post::query()->get();
                
                         return  PostResource::collection($posts);
                    }

                TO

                public function index()
                {
                     $posts = Post::query()->paginate(20);
            
                     return  PostResource::collection($posts);
                }

       Test An API via Postman
             GET : http://laravel-advance.test/api/v1/test/posts

     
               "links": {
                    "first": "http://laravel-advance.test/api/v1/test/posts?page=1",
                    "last": "http://laravel-advance.test/api/v1/test/posts?page=1",
                    "prev": null,
                    "next": null
                },
                "meta": {
                    "current_page": 1,
                    "from": 1,
                    "last_page": 1,
                    "links": [
                        {
                            "url": null,
                            "label": "&laquo; Previous",
                            "active": false
                        },
                        {
                            "url": "http://laravel-advance.test/api/v1/test/posts?page=1",
                            "label": "1",
                            "active": true
                        },
                        {
                            "url": null,
                            "label": "Next &raquo;",
                            "active": false
                        }
                    ],
                    "path": "http://laravel-advance.test/api/v1/test/posts",
                    "per_page": 20,
                    "to": 4,
                    "total": 4
                }

         public function index(Request $request)
            {
                 $pageSize = $request->page_size ?? 20;
                 $posts = Post::query()->paginate($pageSize);
        
                 return  PostResource::collection($posts);
            }
       Test More passing parameter in url of Postman
       http://laravel-advance.test/api/v1/test/posts?page=2&page_size=5

       Pagination is the notion of displaying our query results by page , otherwise we would
        have top send everthing to the client

       We call paginate() method on our query tto create a paginator. We can then pass the paginator
        to our resource collectionn for a paginated Json response.


        2:30:34 Ep18 - Repository pattern
                Software Pattern is a way to write code or a code design paradigm so that the  coding software
                    will be more maintainable in the long run  and to simplify a respostory
                        is a class that handles operations related to our model so if we're going to create
                        a repository for a post model the post repository will contain methods that create
                        or update our post.
                Link: https://dev.to/carlomigueldy/getting-started-with-repository-pattern-in-laravel-using-inheritance-and-dependency-injection-2ohe
                
                 Repositories are classes or components that encapsulate the logic required to access data sources.
                Code will be more mantainable in long run
                 Is the class
                1 : Copy and Paste the block of Code - big no
                2 : Create a generic function
             
              How to archieve the repository in Post Model
                 1: Create a repositories folder in app 
                        app/Repositories
                 2: Create a Class PostRepository   
                        Add three method inside the PostRepository
                            create()
                            update()
                            forceDelete()
                3: Copy the code from store() method in postController, which accept array $attributes arguments
                      
                      $postCreated = DB::transaction(function () use ($request){
                        $postCreated = Post::query()->create([
                            'title' => $request->title,
                            'body'  => $request->body
                        ]);
            
                            /** Associate with a user into pivot table*/
                            $postCreated->users()->sync($request->user_ids);
                
                            return $postCreated;
                        });

                         ##check user_id
                            //Post::query()->create($request->toArray());

                            $postCreated = DB::transaction(function () use ($request){
                    
                                $postCreated = Post::query()->create([
                                    'title' => $request->title,
                                    'body'  => $request->body
                                ]);
                    
                                /** Associate with a user into pivot table*/
                                if ($userIds = $request->user_ids){
                                    $postCreated->users()->sync($request->user_ids);
                                }
                                return $postCreated;
                            });


                            ///Post::query()->create($request->toArray());

                            $postCreated = DB::transaction(function () use ($request){
                    
                                $postCreated = Post::query()->create([
                                    'title' => $request->title,
                                    'body'  => $request->body
                                ]);
                    
                                /** Associate with a user into pivot table*/
                                if ($userIds = $request->user_ids){
                                    $postCreated->users()->sync($userIds);
                                }
                                return $postCreated;
                            });
                        
                       TO 
                    NOTE: data_get() IN LARAVEL  allow to get a values from an arrays by the key
                            public  function  create(array $attributes)
                                    {
                                    return DB::transaction(function () use ($attributes){
                                    
                                       $postCreated = Post::query()->create([
                                           'title' => data_get($attributes,'title', 'Untitled'),
                                           'body'  => data_get($attributes,'body')
                                       ]);
                            
                                       /** Associate with a user into pivot table*/
                            
                                       if ($userIds = data_get($attributes,'user_ids')){
                                           $postCreated->users()->sync($userIds);
                                       }
                        
                                        return $postCreated;
                                           });
                                    }

                 4: Go back to PostController in store method annd inject the instance of PostRepository $repository
                        as arg
                        Sytanx: store(StorePostRequest $request, PostRepository $repository){}

                        Solution:
                            public function store(StorePostRequest $request, PostRepository $repository)
                                {
                                    $postCreated = $repository->create($request->only([
                                        'title',
                                        'body',
                                        'user_ids',
                                    ]));
                                    
                                    return  new PostResource($postCreated);
                                }
                5: Test our end Point
                        POST : http://laravel-advance.test/api/v1/test/posts/

                        VALUES :{
                                    "title":"Repostory Done",
                                    "body" : [],
                                    "user_ids": [1,2]
                                }
                        STATUS: OK


            Update () method  in Post Constroller
               public function update(UpdatePostRequest $request, Post $post){
                 $updatePost = $post->update([
                    'title' => $request->title ?? $post->title,
                    'body' => $request->body  ?? $post->body,
                ]);
                
             
           In the update() method of PostRepository file
                public  function  update(Post $post , array $attributes)
                {
                return DB::transaction(function () use ($post,$attributes){
                $updatePost = $post->update([
                'title' => data_get($attributes, 'title',  $post->title),
                'body'  => data_get($attributes, 'body',   $post->body),
                ]);
                
                           /** throw an Exception*/
                           if (!$updatePost){
                               throw new \Exception('failed to update the post record');
                           }
                
                           /** Sync the User Id Relationship U-P*/
                           if ($userIds = data_get($attributes, 'user_id')){
                               $post->users()->sync($userIds);
                           }
                
                           return $post;
                       });
                
                }
        To use the the update repositorymethod  in the postController 
            Syntax:
                public function update(UpdatePostRequest $request, Post $post, PostRepository $repository)){}
            SOLUTION:
                public function update(UpdatePostRequest $request, Post $post, PostRepository $repository)
                    {
                        $updatePost = $repository->update($post, $request->only([
                            'title',
                            'body',
                            'user_ids',
                        ]));
                       return  new  PostResource($updatePost);
                    }

          5: Test our end Point
                        PATCH : http://laravel-advance.test/api/v1/test/posts/201

                        VALUES :no
                        STATUS: Ok

        Destroy function with repository pattern

            destory () method  in Post Constroller
               public function destroy(Post $post)
                {
                    $deletedPost = $post->forceDelete();
            
                    if (!$deletedPost){
                        return  new JsonResponse([
                            'errors' => [
                                'Could not delete the record'
                            ]
                        ], 400);
                    }
            
                    return  new  PostResource($deletedPost);
                }
                
             
           In the forceDelete () method of PostRepository file
                public  function  forceDelete(Post $post)
                    {
                        return DB:: transaction(function () use ($post){
                        $deletedPost = $post->forceDelete();
                        
                                   /** throw an Exception*/
                                   if (!$deletedPost){
                                       throw new \Exception('cannot delete post');
                                   }
                        
                                   return $deletedPost;
                               });
                    }

        To use the the destroy repository method  in the postController 
            Syntax:
                 public function destroy(Post $post, PostRepository $repository){}
            SOLUTION:
                public function destroy(Post $post, PostRepository $repository)
                    {
                
                        $deletedPost = $repository->forceDelete($post);
                        return  new  JsonResponse([
                            'data' =>'success'
                        ]);
                    }

        5: Test our end Point
                        DELETE :http://laravel-advance.test/api/v1/test/posts/201

                        VALUES :no
                        STATUS: Ok

        LET US GO TO OUR POST REPOSITORY
           - One repository per model,
            - create a base repository class .all will extend to it
         Create a baseRepository class  which will be an abstract class
                1:what is an abstract class ?
                 Will force the child class to implement them
                 The funtion as to be abstract method inside the class
                 Extend to the PostRepository Class
                     BaseRepositoy   -----  Parent
                     PostRepositoy    ----- Child

             app/Repositories/BaseRepository.php
                 abstract class BaseRepository{
                        abstract  function  create();
                        abstract  function  update();
                        abstract  function  forceDelete();
                    }

                new look of our baseRepository
                    abstract class BaseRepository
                    {
                    abstract  function  create(array $attributes);
                    abstract  function  update($model, array $attributes);
                    abstract  function  forceDelete($model);
                    
                    }

            In the PostRepository Class we extends to the parent repository class called baseRepossitory

            Syntax:
                    class PostRepository extends  BaseRepository{}
            
            After :public  function  create(array $attributes)
                        {
                        return DB::transaction(function () use ($attributes){
                        
                                       $postCreated = Post::query()->create([
                                           'title' => data_get($attributes,'title', 'Untitled'),
                                           'body'  => data_get($attributes,'body')
                                       ]);
                        
                                       /** Associate with a user into pivot table*/
                        
                                       if ($userIds = data_get($attributes,'user_ids')){
                                           $postCreated->users()->sync($userIds);
                                       }
                        
                                        return $postCreated;
                               });
                        }
             After :
                   public  function  create(array $attributes)
                        {
                        return DB::transaction(function () use ($attributes){
                        
                                       $postCreated = Post::query()->create([
                                           'title' => data_get($attributes,'title', 'Untitled'),
                                           'body'  => data_get($attributes,'body')
                                       ]);
                        
                                       /** Associate with a user into pivot table*/
                        
                                       if ($userIds = data_get($attributes,'user_ids')){
                                           $postCreated->users()->sync($userIds);
                                       }
                        
                                        return $postCreated;
                               });
                        }

              Before:
                     public  function  update(Post $post , array $attributes)
                        {
                        return DB::transaction(function () use ($post,$attributes){
                        $updatePost = $post->update([
                        'title' => data_get($attributes, 'title',  $post->title),
                        'body'  => data_get($attributes, 'body',   $post->body),
                        ]);
                        
                                   /** throw an Exception*/
                                   if (!$updatePost){
                                       throw new \Exception('failed to update the post record');
                                   }
                        
                                   /** Sync the User Id Relationship U-P*/
                                   if ($userIds = data_get($attributes, 'user_id')){
                                       $post->users()->sync($userIds);
                                   }
                        
                                   return $post;
                               });
                        
                        }

           After:
           public  function  update($post , array $attributes)
            {
                    return DB::transaction(function () use ($post,$attributes){
                    $updatePost = $post->update([
                    'title' => data_get($attributes, 'title',  $post->title),
                    'body'  => data_get($attributes, 'body',   $post->body),
                    ]);
                    
                               /** throw an Exception*/
                               if (!$updatePost){
                                   throw new \Exception('failed to update the post record');
                               }
                    
                               /** Sync the User Id Relationship U-P*/
                               if ($userIds = data_get($attributes, 'user_id')){
                                   $post->users()->sync($userIds);
                               }
                    
                               return $post;
                           });
                    
                    } 
           After:
             

            Before:  

               public  function  forceDelete(Post $post)
                {
                return DB:: transaction(function () use ($post){
                $deletedPost = $post->forceDelete();
                
                           /** throw an Exception*/
                           if (!$deletedPost){
                               throw new \Exception('cannot delete post');
                           }
                
                           return $deletedPost;
                       });
                }

           After:

                public  function  forceDelete($post)
                {
                return DB:: transaction(function () use ($post){
                $deletedPost = $post->forceDelete();
                
                           /** throw an Exception*/
                           if (!$deletedPost){
                               throw new \Exception('cannot delete post');
                           }
                
                           return $deletedPost;
                       });
                }
                
                We can manage of functionalitity of our model in one place .
              We need to finish the rest of CommentRepository _ UserRepository

       Repository us a class that takes care of model operations.   
       Repository manages model operation in once place , and improves the maintainablity of our app.


        2:37:32 Ep19 - Exception
            Exception class and Error Handling 

            Laravel provides the better way to handle errors.
            In laravel we have a foldeer called Exceeptions
                     app/Exceptions/Handler.php
            This class handlers all our exceptiions
            Let us test our exception iin postController inn index() method
            We need to create a laravel exception class
          Syntax:
                php artisan make:exception GeneralJsonException
                app/Exceptions/GeneralJsonException.php

           The General JsonException  has two method
                1: Report Method  - reporting logic send an email to admin , file, will run before rennder
                1: Render  Method w/c accept request as arg  - sending back http response

            1: REPORT METHOD
       
            2: RENDER METHOD
                public  function  render($request)
                    {
                       return new JsonResponse([
                            'errors'=>[
                                'message' =>$this->getMessage(),
                            ]
                       ],$this->code);
                    }
           How to use the rennder method in PostController
                
                throw  new GeneralJsonException('some erroooo',422);

          TEST VIA POST
            GET : http://laravel-advance.test/api/v1/test/posts?page=2&page_size=5
            OUTPUT:
                 {
                    "errors": {
                        "message": "some erroooo"
                    }
                }

       POSTREPOSITORY CLASS
        Add some exception
            syntax:
            1:     if (!$postCreated) {
                   throw new GeneralJsonException('Failed to create Post');
                 }

             2:   throw_if(!$postCreated, GeneralJsonException::class,'Failed to create Post');

             Nb: Second is much better

       HELPER EXCEEPTION FUNCTION
            abort(404);

       Creating custom exception classes in our app can ensure consistent API reponse for error handling
        The report () method is resposible for reporting or loggoing the exception.
        The rennder() method is responsiblee for send the error back to the HTTP client .
        The abort() hepler functio is a quick way to send back an error responsee .
        The resport() helper function calls report() method in the specified exception class.

         REMEMBER TO IMPELEMENT THE EXCEPTION TO ALL MODEL
            Syntax:
                throw_if(!$created, GeneralJsonException::class, 'Failed to create model.');
            return $created;

    

        2:47:23 Ep20 - Event & event listener & subscriber
          - When the new post has beeenn create  we need to trigger an event
              1: Create a service class
                    we can put all the mailing logic on it and call the servicee class to our controller
              2: Event + Event Listner
                   example
                            If the task has been completed - fire UserCreated event
                                    this event will broadcasted to all app
                            Listener will send wellcom email to the  user

                  Event Listener is functionn listen to a event

        HOW TO USE THE EVENT LISTNER -  USER REPOSITORY CLASS
            The event will be implemeted inside the UserRepository class .
           
                CODE: app/Repositories/UserRepository.php
                    create() method
                    update() method
                    forceDelete() method

               TERMINAL:
                    php artisan make:event UserCreated
               app/Events/UserCreated.php
            The above class command will create a UserCreated class ,it uses few traits of the box

              TRAITS: use Dispatchable, InteractsWithSockets, SerializesModels;

           Meant to work with Ques and websocket

        The constructor accept the user model but we need to set the protected property
                protected  $user;
             
             public function __construct(User $user)
                {
                    $this->user = $user;
                }
        We need to firing up (Dispatch) this our event to the UserRepository 
            In the UserRepository class 
                    create(){
                               event(new UserCreated($UserCreated));
                            }

     LISTENER EVENT
        php artisan make:listener SendWelconeEmail
     Will create another folder caller Listener
            app/Listeners/SendWelconeEmail.php

         In handle method will define our logic when the event is dispatched,
        we need to send our welcome mssg to our user
       In UserController  index() method 
            public function index()
            {
                event(new UserCreated(User::factory()->make()));
           }

      To Link our event to our Listner
            app/Providers/EventServiceProvider.php

              protected $listen = [
                    Registered::class => [
                        SendEmailVerificationNotification::class,
                    ],
            
                    //Mapping
                     UserCreated::class =>[
                         SendWelcomeEmail::class,
                     ]
                ];

      WE NEED TO CREATE A FOLDER CALLED MODELS IN EVENTS 
            1:  app/Events/Models
            2: Insidee of Models folder create a folder called Users
                app/Events/Models/Users
            3: Move the UserCreated into the Users folder
                app/Events/Models/Users/UserCreated.php
            
     WE NEED TO CREATE  EVENTS THE FOLLOWING
            DeletedCreated
            UpdatedCreate
            php artisan make:event UpdatedCreated     
            php artisan make:event UpdatedCreated 
           
             On each we need to pass even ,should pass the user model ,initialize the protected $user;
        
     WE NEED TO REGISTER OUR DISPATCH EVENT IN USERREPOSITORY  
            update() method
                event(new UpdatedCreated($user));

            delete() method
                event(new  DeletedCreated($user));

    WE NEEED TO CREATE OUR EVENT LISTNER 
        Organise our code with Subscriber 
        we need to create a subscriber from scratch
            app -> create folder -> Subscriber
        Inside the Subscriber create Models folder
            Subscriber -> create folder -> Models
        Inside the Models create UserSubscriber class
            Will have subscriber method w/c will have Dispatcher 
                //listiner method from our dispatcher to MAP our event
              public  function  subscribe(Dispatcher $events)
                 {
                     //listiner method from our dispatcher to MAP our event
                     $events->listen(UserCreated::class, SendWelcomeEmail::class);
                 }

       WE NEED TO REGISTER OUR SUBCRIBER 
         - We reegister subscriber into EvenServiceProvider
                protected  $subscribe = [
                UserSubscriber::class
            ];

       REMEMBER : comment out the  Mapping inside the EventServiceProvider
            //Mapping
                 /*UserCreated::class =>[
                     SendWelcomeEmail::class,
                 ]*/

      TEST OUR CODE VIA POSTMAN
        GET : http://laravel-advance.test/api/v1/test/users
       
      NB: WE USE THE SUBRIBER IF WE BUILD LARGE APPLICATION , UNLESS USE EVENT ON SMALL APPLICATION.

     USE THE SAME TECHNIQUES ON POST AND COMMENT TO IMPLEMENT  EVENTS
                1:  POST
                2:  COMMENT


        2:55:46 Ep21 - Sending email
            Send email innsid event lisitner
        3:06:29 Ep22 - Unit Test vs Feature Test vs E2E Test
        3:12:29 Ep23 - Unit Testing Essentials
        3:25:44 Ep24 - Testing API routes | Feature Testing
        3:42:14 Ep25 - Phpunit with Live Reload?! Productivity Hacks
        3:46:36 Ep26 - Composer Script | Productivity Hacks
        3:50:22 Ep27 - Test Driven Development (TDD) Basics | Laravel API Server
        3:58:31 Ep28 - Opinion on Testing: how much is enough?
        4:03:48 Ep29 - Validating Request
        4:13:53 Ep30 - Custom Validation with Validator
        4:21:32 Ep31 - Laravel IDE helper
        4:25:19 Ep32 - Config and Env Var
        4:29:49 Ep33 - Documenting API with API Generator
        4:41:58 Ep34 - Throttle Middleware and Rate limiting
        4:47:39 Ep35 - Authentication with Laravel Fortify: An Overview
        4:55:16 Ep36 - Laravel Fortify: Auth, Registration and Password Reset
        5:07:44 Ep37 - Laravel Fortify: Email Verification and Updating User Profile
        5:17:44 Ep38 - Laravel Fortify: 2 Factor Authentication | Laravel API Server
        5:27:25 Ep39 - Customising Fortify Email Verification
        5:35:32 Ep40 - Customising Fortify Authentication
        5:43:04 Ep41 - Laravel Sanctum
        5:59:02 Ep42 - Testing Auth
        6:04:05 Ep43 - Providing Translation - i18n | Laravel API Server
        6:17:38 Ep44 - Creating private links that will expire in Laravel?! | Signed route
        6:29:18 Ep45 - Notification
        6:38:17 Ep46 - Websockets: Concept Overview
        6:47:12 Ep47 - Laravel Websockets: Broadcasting Setup and Config
        6:56:50 Ep48 - Broadcasting Events and Websocket Channels | Laravel API Server
        7:07:50 Ep49 - Laravel Echo & WebSockets | Building a Chat App
        7:18:48 Ep50 - Private and Presence Channels
        7:31:08 Ep51 - “P2P” WebSockets?! - Whisper | Laravel API Server
        7:35:48 Ep52 - Laravel Websocket: Sending Realtime Data With RPC
        7:48:53 Ep53 - Laravel Websocket with SSL
