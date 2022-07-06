<?php

namespace App\Subscriber\Models;

use App\Events\Models\User\UserCreated;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
     public  function  subscribe(Dispatcher $events)
     {
         //listiner method from our dispatcher to MAP our event
         $events->listen(UserCreated::class, SendWelcomeEmail::class);
     }
}
