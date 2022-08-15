###  Config and Env Var
    [X] Laravel manage the easy way to do configuration .
    [X] All the Configuration are stored in Config Folder .
    [X] It's easy to read the config from an array .
            Example: php artisan tinker
                     config("database.connections.mysql.driver")
                     config("filesystems.disks.local.driver")    
            Syntax:  config  (Filaname, keys inside the arrays
            Evn Var: env("APP_URL")
    [X] We don't push the config to the github, it contains sensitive information .
    [X] We don't push the Env to the github, it contains sensitive information .
    [X] We can create our own api from config Payment  .
        
        Config() is handy helper function to access configuration values from the config folder .           
        Wee use thee 'dot notation' to access the configuration .
        Env() is a helper function to access enviroment variables .Inside .env
