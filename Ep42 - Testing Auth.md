### Testing Auth
    [X] Test all our api  endpoin,but it returns errors .
    [X] Log as ActingAs user
             $this->actingAs($user);
    [X] creating a dummy user and pass
         $user = User::factory()->create();
    [X] Run test again
        Terminal : composer run-script --test     
    [X] Auth an API TEST 
            $user = User::factory()->create();
            $this->actingAs($user);
    [x] Do we need to copy and paste to all test ? NO NOOOOOOOO
    [X] We need to use the following method, which laravel provide for us
            1: Setup() : 
                        Run before each test has been executed
            1: Teardow() : 
                        Run after each test has been executed
                        Deleting files
    [X] We need to login the user before each test has been executed, by setUp() method above index
             public function  setUp(): void
            {
                parent::setUp();
        
                //creating a dummy user and pass
                $user = User::factory()->create();
                $this->actingAs($user);
            }
    [X] Copy the above code to all tests.
    [X] Run the test again
    [X] Change some fews code inside PostFactory
            'body'  => ['abc'], instead of 'body'  => [],
    [X] In the PostApiTest  where the store method
         Orginal:   $response = $this->json('post','/api/v1/test/posts', $dummyPost->toArray());
         To :       $response = $this->json('post','/api/v1/test/posts', array_merge($dummyPost->toArray(), ['user_ids' =>[$dummyUser->id]]));
    [X] Run the test again
    [X] You can add the web ,api in the setUp()

      Laravel provides us a convenient  actingAs() method to login as any given user .
      setUp() is a handy special funnction that run before every test function.
      teardown() is the opposite of setUp(). teardown() run after every test function
      actingAs() accepts a second argumennt where we can specify which auth guard that we want to use .
