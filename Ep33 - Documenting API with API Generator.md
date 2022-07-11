### Documenting API with API Generator
    [X] With Scribe
    [X] Doc is for our  future 
    [X] It's pain to write the API Doc .
    [X] Any better way to write the Doc .
    [X] Wonder package to write an api with Shalvah
            https://github.com/knuckleswtf/scribe
            https://scribe.knuckles.wtf/laravel/
    [X] It will do much for heavy lifting for us .
    [X] Install the package .
        Steps: 
            1: composer require --dev knuckleswtf/scribe
            2: php artisan vendor:publish --tag=scribe-config
    [X] Let us look the config folder
            Path:  config/scribe.php
    [X] We should be careful in the 
            'type' => 'static',
             'match' => [],
    [X]  Let us try to test after installation of our package
        Command:   php artisan scribe:generate
    [X] You can acceess the api documentation 
        Folder:  public/docs 
    [X] You can access the Documentation via 
            php artisan server 
            OUTPUT :
                 http://127.0.0.1:8000/docs#endpoints-GETapi-v1-test-comments
            Error of accessing via valet server
    [X] Scribee doesn't group the api point base on each resources .
    [X] If you want group the resource inside userController .We need to insert the phpDocs
        This PHPDocs will generate the group.
          Syntax:
                 /**
                 * @group  User Management
                 *
                 *APIs to manage the user resource.
                 */
    [X] To generate the index API Docs
    [X] Scribe will interact with our database . To show in api documentation
    [X] Clear our database . php artisan migrate:fresh --seed
            
