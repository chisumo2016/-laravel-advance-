        ### Laravel Resource Class | API Resource | Robust API Response
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
