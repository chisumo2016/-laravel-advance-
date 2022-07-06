<?php

namespace App\Repositories;

use App\Events\Models\posts\PostCreated;
use App\Events\Models\posts\PostDeleted;
use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends  BaseRepository
{
   public  function  create(array $attributes)
   {
            return DB::transaction(function () use ($attributes){

               $postCreated = Post::query()->create([
                   'title' => data_get($attributes,'title', 'Untitled'),
                   'body'  => data_get($attributes,'body')
               ]);

               throw_if(!$postCreated, GeneralJsonException::class,'Failed to create Post');

                 event(new PostCreated($postCreated));

               /** Associate with a user into pivot table*/

               if ($userIds = data_get($attributes,'user_ids')){
                   $postCreated->users()->sync($userIds);
               }

                return $postCreated;
       });
   }

    /**
     * @param Post $post
     * @param array $attributes
     * @return mixed
     */
    public  function  update($post , array $attributes)
   {
       return DB::transaction(function () use ($post,$attributes){
           $updatePost = $post->update([
               'title' => data_get($attributes, 'title',  $post->title),
               'body'  => data_get($attributes, 'body',   $post->body),
           ]);

           /** throw an Exception*/

           throw_if(!$updatePost, GeneralJsonException::class,'failed to update the post record');

           event(new PostCreated($post));

           /** Sync the User Id Relationship U-P*/
           if ($userIds = data_get($attributes, 'user_id')){
               $post->users()->sync($userIds);
           }

           return $post;
       });

   }


    /**
     * @param Post $post
     * @return mixed
     */
    public  function  forceDelete($post)
   {
       return DB:: transaction(function () use ($post){
           $deletedPost = $post->forceDelete();

           /** throw an Exception*/
           throw_if(!$deletedPost, GeneralJsonException::class,'cannot delete post');

           event(new PostDeleted($post));


           return $deletedPost;
       });
   }
}
