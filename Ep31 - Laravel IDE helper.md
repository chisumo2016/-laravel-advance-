###  Laravel IDE helper
    [X] When your IDE has no autocomplete. 
    [X] Install the Package
            PACKAGE : https://github.com/barryvdh/laravel-ide-helper 
            TERMINAL: composer require --dev barryvdh/laravel-ide-helper
                    : php artisan ide-helper:generate
    [X] composer.json
            "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan ide-helper:generate",
            "@php artisan ide-helper:meta",
            "@php artisan package:discover --ansi"
        ],
            delete : _ide_helper.php
             TERMINAL: composer dump-autoload -o

     Laravel uses a lot of facades amnd magic methods that are not IDE friendly .
     The IDE helper package solves this issue by generating an '_ide_helper.php' file to aid the autocompletion.
