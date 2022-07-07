###  Phpunit with Live Reload Test
        [X] To run the test on the terminal sometime can be headache .
            There's any way to trigger the test insted of running on terminal whenn runnning test.? 
        [X]  BIG YES
        [X]  Package called PHPUNIT-WATCHER - Watch the changes in phpunit and run the test .Our code changes.
                PACKAGE: https://github.com/spatie/phpunit-watcher
                BINARY: ./vendor/bin/phpunit-watcher
                TERMINAL: 
                        composer require spatie/phpunit-watcher --dev
                        phpunit-watcher watch
            
  
                ERROR: 
                    Installation failed, reverting ./composer.json and ./composer.lock to their original content.
                REASON: Not compatible with Laravel 9
        PHPUnit Watcher is a wonderful packages that automatically rerun our test whenever there is a change inn our source code .
        It is a great tool that will save us lots of time and make us happier inn the lonng run .
  
