            ### Ep08 - All about models and relationships
                
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
