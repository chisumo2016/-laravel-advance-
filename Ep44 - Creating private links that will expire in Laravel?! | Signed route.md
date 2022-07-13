###   Creating private links that will expire in Laravel?! | Signed route
        [X] How to generate these links in laravel ?
        [X] Thanks laravel provide the facility.
        [X] Only people with special links can access it ,protect
        [X] We can achieve this by Signed_url (protecting) from future tempering .
                     Route::get('/shared/videos/{video}' , function (){
                        return 'good';
                    })->name('share-video');
                
                    Route::get('/playground2', function () {
                        $url = URL::temporarySignedRoute('share-video',now()->addSeconds(30),['video' => 123]);
                        return $url;
                    });

        [X] To test the code via postman 
                http://laravel-advance.test/playground2
        [X] It contains EXPIRES annd SIGNATURE in url 
                  Expire is timestamp this url will expire 
                  Signature is the unique hash which will stop people from temperating this url
        [X] It the mechannism to stop thee url from modification
        [X] Provide the logic for the signature to protect our route
                1: hasValidSignature()
                2: middleware('signed') much cleaner
        [X]Test via Postman
                http://laravel-advance.test/playground2
        [X] How this works behind the  sciene .
                1: kernel.php file   'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
                  FoundationServiceProvide
        [X] To share the route privately 
                Route::get('/shared/posts/{post}' , function (\Illuminate\Http\Request $request, \App\Models\Post $post){
                    return  "Specially made just for you Post Post ID :{$post->id}";
            
                })->name('share.post')->middleware('signed');


                public function share(Request $request, Post $post)
                {
                    $url = \URL::tomporarySignedRoute('shared.post', now()->addDay(30), [
                        'post' => $post->id,
                    ]);
            
                    return  new  JsonResponse([
                        'data' => $url
                    ]);
                }

        We can use signed routes to protect our routes from unawanted modification .
        We use URL::temporarySignedRoute() to create a link with expirationn, while URL::signedRoute() to create
            permanent link .
        Laravel uses salted sha256 to hash the route as measure to prevent modification .(videos or file).
        
