### Customising Fortify Email Verification
     [X] start to customize within app/Providers/AuthServiceProvider.php
     [X] start to customize within app/Providers/AuthServiceProvider.php
     [X]create verify mail file insiide mail   resources/views/mail/verify.blade.php
     [X] create a ui OF VerifyMail
             php artisan make:mail VerifyMail     
     [x] Write the logic insidee the VerifyMail class
            app/Mail/VerifyMail.php

        Laravel Fortify relies oon the built-in VerifyEmail class provided by Laravel to send out 
            verification email .
        We call VerifyEmail::toMailUsing() to define our own logic to send out the verification notification .
        We can encode information into Laravel's signed route for validation in the future .
