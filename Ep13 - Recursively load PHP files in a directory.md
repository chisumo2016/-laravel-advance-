        ### Recursively load PHP files in a directory

             Automatically Load Files Recursively
            Automatically Load Files Recursively via iterator

               Route::prefix('v1')
                ->group(function (){
                  require __DIR__ . '/api/v1/users.php';
                  require __DIR__ . '/api/v1/posts.php';
                  require __DIR__ . '/api/v1/comments.php';
            });

     The above code if it grow bigger will bee mess, solution is 
            Iterate through the v1 foldeer recursively
            $dirIterator = new RecursiveDirectoryIterator(__DIR__ . '/api/v1');
            Require the file in each iteration

     BETTER WAY:

            Route::prefix('v1')
                ->group(function (){
            
                     $dirIterator = new RecursiveDirectoryIterator(__DIR__ . '/api/v1');
            
                     /** @var  RecursiveDirectoryIterator | RecursiveIteratorIterator $it */
                     $it = new RecursiveIteratorIterator($dirIterator);
            
                     while ($it->valid() ){
                         /** Check*/
                         if(!$it->isDot()
                             && $it->isFile()
                             && $it->isReadable()
                             && $it->current()->getExtension() === 'php')
                         {
                             /** return file path 2 WAYS*/
                             require $it->key();//SIMPLE
                             //require $it->current()->getPathname();
                         }
                        $it->next();
                     }
                 /* require __DIR__ . '/api/v1/users.php';
                  require __DIR__ . '/api/v1/posts.php';
                  require __DIR__ . '/api/v1/comments.php';*/
            });
       
     We need top create a Helpers Routes
        create a app->Helper -> Routes
                app/Helpers/Routes/RouteHelper.php
         We copy our code which we have written in api.php into the RouteHelper method

            public  static  function  includeRouteFiles(string $folder)
            {
                
             }

        To ACCESS the includeRouteFiles(string $folder) into the api.php 
                \App\Helpers\Routes\RouteHelper::includeRouteFiles(__DIR__ .'/api/v1');

       Iterator is an object that allows us to iterate through a series of items .
       The directory iterator can helps us to automatically load our routes in folder
