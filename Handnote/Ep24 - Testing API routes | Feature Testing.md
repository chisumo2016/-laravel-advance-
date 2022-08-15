###  Testing API routes | Feature Testing  
        [X] Feature Testing Essentials
                1. Testing a group of functions working correctly rather than individual function.
                2: API end point consider multiple function workig together
        [X] Create the folder Api inside thee Feature Test folder
                    tests/Feature/Api
        [X] Create the folder V1 inside the Api folder
                    tests/Feature/Api/V1
        [X] Create the folder Post inside the V1 folder to test our endpoint
                    tests/Feature/Api/V1
        [X] Generate our API via terminal
                    php artisan make:test PostApiTest
        [X] Move the created PostApiTest into post folder
                    tests/Feature/Api/V1/Post/PostApiTest.php
        [X] Our PostRepository class container three functions
                    1: index()
                    2: create()
                    3: update()
                    4: delete()
       [X] Testing Rules to follow inside the function body
                    1: Load data in DB
                    2: call the http request index endpoint
                    3: assert status to http response
                    3: verify the record return from http request, see if it matching with our database records
                    5: Data payload to our response
                    5: we can use dot notatioon to accept - Array and acccept property
                            $data = $response->json('data.19');
                            $data = $response->json('data.19.id');
                    
       [X] Test our APi
                ./vendor/bin/phpunit --filter=PostApiTest
       [X] Reset our data when we createe a new record
            use RefreshDatabase; thiss trait will slow much our testing
            Or you can use the in-memory sqlite db rather than mysql instance
            In Memory Sqlite -> Go to ->phpunit.xml
            Uncomment the  
                    <!-- <env name="DB_CONNECTION" value="sqlite"/> -->
                     <env name="DB_CONNECTION" value="sqlite"/> 

            touch database/database.sqlite

            ERROR: Illuminate\Database\QueryException: Database (laravel_advance) does not exist. (SQL: PRAGMA foreign_keys = ON;)
       [x] Test our Api Endpoint
            ERROR: in_array(): Argument #2 ($haystack) must be of type array, Illuminate\Support\Collection given
            SOLN: We need to convert into array ->toArray() helper method

       [X] To test ann event inside the PostRepository
                  Event::fake();


                Event::assertDispatched(PostCreated::class);

      [ X] Test our update() methods
            1: create a dumy record
            2: create a fake dumy2 record
            3: we should know what field can we update?
            3: getFillable(); return an array
            3: loop through our fillables
            3: test  assertStatus Test the status code is 200
            3:  test the event
                    Event::fake();
                    .....codee in btn ......
                    Event::assertDispatched(PostUpdated::class);

       X] Test our delete() methods
            1: create a dumy record
            2: send a delete request to delete dumy model
            3: Test the status code is 200
            4: We will call the exception, ModelNotFoundException
            5: After this the database will not have a record anymore
            6: test  assertStatus
            7:test the event
                    Event::fake();
                    .....codee in btn ......
                    Event::assertDispatched(PostUpdated::class);
            8: Run the test if it pass

     NOTE: REMEMBER TO WRITE THE TEST FOR THE FOLLOWING PLEASE AS EXERCISE
                    1: USER  REPOSITOSY TEST
                    2: COMMEN TREPOSITOSY TEST
            
     Providing thee '-filter; flag to PHPUNIT allows us to run a specific test .
     Event::fake() from facades stops events form dispatching in oour app and allows us to capture and assert
        event dispatching .
    The json() method allows us to easily perform HTTP request to our API endpoints.

