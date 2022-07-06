<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Comment;

use Illuminate\Support\Facades\DB;

class CommentRepository extends  BaseRepository
{
   public  function  create( array $attributes)
   {
       return DB::trannsaction(function () use ($attributes){

           $commentCreated = Comment::query()->create([
               //'title' => data_get($attributes, 'title'),
               'body' => data_get($attributes, 'body'),
               'user_id' => data_get($attributes, 'user_id'),
               'post_id' => data_get($attributes, 'post_id'),
           ]);

           throw_if(!$commentCreated, GeneralJsonException::class, 'Failed to create model.');

           return $commentCreated;
       });
   }

    /**
     * @param Comment $comment
     * @param array $attributes
     * @return mixed
     */
   public  function  update($comment , array $attributes)
   {
       return DB::trannsaction(function () use ($comment, $attributes){

           $updateComment = $comment->update([
               'body' => data_get($attributes, 'body', $comment->body),
               'user_id' => data_get($attributes, 'user_id', $comment->user_id),
               'post_id' => data_get($attributes, 'post_id', $comment->post_id),
           ]);

           /*if(!$updateComment){
               throw new \Exception('Failed to update comment');
           }*/

           throw_if(!$updateComment, GeneralJsonException::class, 'Failed to update comment');

           return $comment;

       });


   }

    /**
     * @param Comment $comment
     * @return mixed
     */
   public  function  forceDelete($comment)
   {
       return DB::trannsaction(function () use ($comment){

           $deletedComment = $comment->forceDelete();

           /*if(!$deletedComment){
               throw new \Exception("cannot delete comment.");
           }*/
           throw_if(!$deletedComment, GeneralJsonException::class, 'cannot delete comment');

           return $deletedComment;
       });
   }
}
