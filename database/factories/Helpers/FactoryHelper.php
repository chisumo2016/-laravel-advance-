<?php

namespace Database\Factories\Helpers;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryHelper
{
    /**
     * @param string | HasFactory $model
     * This function will get the random Id from database
     */
    public  static  function  getRandomModelId(string $model)
  {
      /** Get model count **/
      $count = $model::query()->count();

      /** if model count is 0  **/
      if ($count === 0){

          /** we should create a new record and retrieve the record id**/
          return $model::factory()->create()->id;

      }else{
          /** Generate random number between 1 annd model count **/
          return rand(1,$count);
      }
  }
}
