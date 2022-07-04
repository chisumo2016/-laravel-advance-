        Timestamps:
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
        1:39:35 Ep11 - Controllers
        1:47:22 Ep12 - Laravel API Routes Best Practices
        1:59:56 Ep13 - Recursively load PHP files in a directory
        2:05:36 Ep14 - Essential Eloquent Methods & Properties
        2:16:18 Ep15 - DB Transaction
        2:20:00 Ep16 - Laravel Resource Class | API Resource
        2:24:49 Ep17 - Pagination
        2:30:34 Ep18 - Repository pattern
        2:37:32 Ep19 - Exception
        2:47:23 Ep20 - Event & event listener & subscriber
        2:55:46 Ep21 - Sending email
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
