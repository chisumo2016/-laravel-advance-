###  Composer Script | Productivity Hacks
        [X] Power up with Composer Scripts
                composer.json file
        [X] Composer script it allow us to run the long via composer
        [X] Create a script insidee composer.json
                Code:
                            "test": "./vendor/bin/phpunit",
                        "test:watch": "./vendor/bin/phpunit-watcher watch",
                        "playground": [
                            "ls"
                        ]
               Run Command : composer run-script playground
               Run Command : composer run-script test:watch
       Composer scripts are handy shorthand that allows us to definnee and run complex commands.
       If wee want to pass arguments to our scripts, we need to supply an additional '__' after the scripts name .
