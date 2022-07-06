<?php

namespace App\Repositories;

use App\Events\Models\User\DeletedCreated;
use App\Events\Models\User\UpdatedCreated;
use App\Events\Models\User\UserCreated;
use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends  BaseRepository
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public  function  create(array $attributes)
   {
       return DB::transaction(function () use ($attributes){

           $UserCreated = User::query()->create([
               'name'      => data_get($attributes, 'name'),
               'email'     => data_get($attributes, 'email'),
               'password'  => data_get($attributes, 'password'),
           ]);

           throw_if(!$UserCreated, GeneralJsonException::class, 'Failed to create model.');

           event(new UserCreated($UserCreated));

           return  $UserCreated ;
       });

   }

    /**
     * @param $user
     * @param array $attributes
     * @return mixed
     */
    public  function  update($user, array $attributes)
   {
       return DB::transaction(function () use($user, $attributes) {

       $updateUser = $user->update([
           'name'      =>  data_get($attributes, 'name',     $user->nam),
           'email'     =>  data_get($attributes, 'email',    $user->email),
           'password'  =>  data_get($attributes, 'password', $user->password),
       ]);

           /*if(!$updateUser){
               throw new \Exception('Failed to update user record');
           }*/
           throw_if(!$updateUser, GeneralJsonException::class, 'Failed to update model.');

           event(new UpdatedCreated($user));

           return $updateUser;
       });
   }

    /**
     * @param $user
     * @return mixed
     */
    public  function  forceDelete($user)
   {
       return DB::transaction(function () use($user) {
           $deletedUser = $user->forceDelete();

       /*if(!$deletedUser){
           throw new \Exception("cannot delete user.");
       }*/
           throw_if(!$deletedUser, GeneralJsonException::class, 'Failed to delete model.');

          event(new  DeletedCreated($user));

       return $deletedUser;
      });
   }
}
