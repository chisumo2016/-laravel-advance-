        ###  Pagination
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
