            ### Ep19 - Exception

                     Exception class and Error Handling 

            Exception class and Error Handling 

            Laravel provides the better way to handle errors.
            In laravel we have a foldeer called Exceeptions
                     app/Exceptions/Handler.php
            This class handlers all our exceptiions
            Let us test our exception iin postController inn index() method
            We need to create a laravel exception class
          Syntax:
                php artisan make:exception GeneralJsonException
                app/Exceptions/GeneralJsonException.php

           The General JsonException  has two method
                1: Report Method  - reporting logic send an email to admin , file, will run before rennder
                1: Render  Method w/c accept request as arg  - sending back http response

            1: REPORT METHOD
       
            2: RENDER METHOD
                public  function  render($request)
                    {
                       return new JsonResponse([
                            'errors'=>[
                                'message' =>$this->getMessage(),
                            ]
                       ],$this->code);
                    }
           How to use the rennder method in PostController
                
                throw  new GeneralJsonException('some erroooo',422);

          TEST VIA POST
            GET : http://laravel-advance.test/api/v1/test/posts?page=2&page_size=5
            OUTPUT:
                 {
                    "errors": {
                        "message": "some erroooo"
                    }
                }

       POSTREPOSITORY CLASS
        Add some exception
            syntax:
            1:     if (!$postCreated) {
                   throw new GeneralJsonException('Failed to create Post');
                 }

             2:   throw_if(!$postCreated, GeneralJsonException::class,'Failed to create Post');

             Nb: Second is much better

       HELPER EXCEEPTION FUNCTION
            abort(404);

       Creating custom exception classes in our app can ensure consistent API reponse for error handling
        The report () method is resposible for reporting or loggoing the exception.
        The rennder() method is responsiblee for send the error back to the HTTP client .
        The abort() hepler functio is a quick way to send back an error responsee .
        The resport() helper function calls report() method in the specified exception class.

         REMEMBER TO IMPELEMENT THE EXCEPTION TO ALL MODEL
            Syntax:
                throw_if(!$created, GeneralJsonException::class, 'Failed to create model.');
            return $created;
