### Ep23 - Unit Testing Essentials

        [X]  Let look in test in laravel folder
        [X]  We Seetup our testinng via phpunit.xml
        [X]  To write a test we use the command
                php artisan make:test --help
        [X]  Test PostRepositoryTest 
                php artisan make:test --unit PostRepositoryTest  
        [X]  Writing the test ,we should aware our checking what we're testing PostRepositoryTest
                
                1. create()
                2. update()
                3. delete()
        [X]  We use the snake case  short cut pubf
        [X]  Define our goals
                1. Define the goal-> our post can be created.
                    test if create() will actually create a record in the DB
                2. Replicate the env / restriction if available
                     use PHPUnit\Framework\TestCase; change to use our laravel
                        use Tests\TestCase;
                    $repository = $this->app->make(PostRepository::class);
                3. Define the source of truth, 
                3. Compare our results , create() from our repository
                     assertSame  campare two value ==
                     assertSame(what is expected in payload array, actual what we get, error message if it fail)
                
                    
         [X]  Test our Test
               ./vendor/bin/phpunit  
        [X]  Update Method
                1. Goal: make sure we can update a post using the update
                2. Replicate the env / restriction if available
                3. Define the source of truth, 
                4. Compare our results , create() from our repository
                        Exception: Property [title] does not exist on this collection instance.
                     PostRepository is returninng collection instead of model instance .

        [X]  Delete  Method
                1. Goal: test if forceDelete() id working
                2. Replicate the env / restriction if available
                3. We dont have the source of truth, 
                4. Compare our results , forceDelete( from our repository
                4. verify if it is deleted , finding the record in the database
                        
        [X] We need to write our test for UserRepository and CommentRepository
        [X] We the test in HAPPY PATH
        [X] What if the  post doesnt exist ?
            
                . Laravel uses PHPunit as its official testing library
                . Laravel provides a TestCasee class which is basically ann enhanced version of the
                    provided by PHPunit .
                . Laravel's TestCases loads a lot of helper methods for us to use.
                .We should write test on both "HAPPY PATH" and "SAD PATH" four our functions.
