            ### Seeding relationships
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
