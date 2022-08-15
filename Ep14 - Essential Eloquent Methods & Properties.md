        ### Ep14 - Essential Eloquent Methods & Properties
        
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
