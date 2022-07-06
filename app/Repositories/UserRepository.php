<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\JsonResponse;
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

           if(!$updateUser){
               throw new \Exception('Failed to update user record');
           }

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

       if(!$deletedUser){
           throw new \Exception("cannot delete user.");
       }

       return $deletedUser;
      });
   }
}
