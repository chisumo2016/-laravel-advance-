        ### Repository pattern
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
