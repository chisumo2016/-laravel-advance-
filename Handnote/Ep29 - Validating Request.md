##  Validating Request
        [X] You should ever ever trust the user input .
        [X] CRS Injection .
        [X] Validating user input is very important thing building an app .
        [X] Laravel make very easy for validating user input
        [X] There are few way to validate the input 
                1: By Request Class
                Terminal: php artisan make:request PostStoreRequest
                  It has simple methods authorize and rules
                  Two ways to appy multiple rules
                             A:  'string|required',
                             A: Array ['string','required'],
        [x] Inject to our store method in PostController
        [x] Test via Post Postman
               Headers:
                    KEY:                VALUEE
                    Content-type         application/json
                    Accept               application/json
        [X] You can customizze the message
        [X] Custom validation based on closure
        [X] Refactor our closure to deeliicated class.
                 /** Custom validation based on closure*/
                function($attribute, $value ,$fail){
                    $integerOnly = collect($value)->every(fn($element) => is_int($element));
                        /**One of element isn't Integer*/
                    if (!$integerOnly){
                        $fail($attribute . ' Can only be integers');
                    }
                }
           Terminal: php artisan make:rule  InterArray 
        [X] Simple class which impelemt  an interface class .
                    passes() - Put the logic
                        public function passes($attribute, $value)
                        {
                            return collect($value)->every(fn($element) => is_int($element));
                        }

                    message() - Put the message
                         public function message()
                        {
                            /**$attribute . ' Can only be integers'*/
                            return  ':attribute Can only be integers';
                        }

        [X] To implement the InterArray in the StorePostControler 
                     new InterArray(),

       We can define Requests class to easily validate incoming HTTP requests .
       We inject Request class in controller methods to get Laravel to perform validation on the 
         incoming requests .
       We can create CUSTOM VALIDATION rule either by CLOSURE or a dedicated rule class .








