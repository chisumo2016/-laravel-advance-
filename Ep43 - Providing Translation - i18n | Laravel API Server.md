### Providing Translation - i18n
    [X] We put all the translation files inside the folder:
            Folder:  lang   
                     lang/en
    [X] Is the folder where we put the translatiion files
    [X] create a folder called es and copy the  php files fromm en folder
    [X] Two main ways to get the translations keys .
            1: Use the Lang Facades
                $trans = Lang::get('auth.failed');
                dd($trans);
            2: Use the helper functions 
                $trans = __('auth.password') ;
                 
    [X] You can change the default language in  config file
            config/app.php
            'locale' => 'en', or 
                Lang::setLocale('es');
    [X] Test the application we can run 
            php artisan serve
    [X] To replace seconds into number.
         $trans = __('auth.throttle', ['seconds' => 5]) ;
    [X] To get the current locale
        dump(\Illuminate\Support\Facades\App::currentLocale());
        dump(App::isLocal('en'));
    [X] We can use the Json file to run en files
          lang/es.json
    [X] Which one to choose? Json or php file:Its up to you
    [X] Pluralization, each language has different pluralization 
    [X] To get the plural form ,laravel use trans_choice() method
                $trans = trans_choice('auth.pants', 1); 0 or -1 
    
    [X] We can capitalizee the key
        View the code inn web file

    Internationalization 0r i18n is the notion of providing translation to different locale.
    We can use __() or Lang::get() to retrieve translatios from the language files.
    Laravel put all the translation files inn the resoources lang directory
    We can choose to write our tranlation files in either php or json file format.
    trans_choice() is a helper functions for us to handle pluralization.
