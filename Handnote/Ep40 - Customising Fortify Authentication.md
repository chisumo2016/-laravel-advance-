###  Customising Fortify Authentication
     [X] To archieve that , we can look on FortifyServiceProvvider
                app/Providers/FortifyServiceProvider.php
     [X] All methods has been implemented into FortifyServiceProvider class
     [X] create d a dumy class in app/Actions/Fortify/DummyDumy.php

           We use Fortify::authenticatedUsing() to override the default login logic .
           We use Fortify::authenticateThroough() allow us to customise the authentoicated pipeline .
           We use Fortify::confirmPasssword() provides a way to customise the password confirmation logic .
