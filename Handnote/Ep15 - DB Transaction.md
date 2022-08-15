        ###  DB Transaction

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
