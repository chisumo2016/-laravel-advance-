<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
         $posts = Post::query()->get();

         return  PostResource::collection($posts);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return PostResource
     */
    public function store(StorePostRequest $request)
    {
        //Post::query()->create($request->toArray());

        $postCreated = DB::transaction(function () use ($request){

            $postCreated = Post::query()->create([
                'title' => $request->title,
                'body'  => $request->body
            ]);

            /** Associate with a user into pivot table*/
            $postCreated->users()->sync($request->user_ids);

            return $postCreated;

        });


        return  new PostResource($postCreated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return  new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return PostResource | JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post)
    {

        $updatePost = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body  ?? $post->body,
        ]);



       if (!$updatePost){
           return  new JsonResponse([
               'errors' => [
                   'Failed to updated the record model'
               ]
           ], 400);
       }

       return  new  PostResource($updatePost);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return PostResource| JsonResponse
     */
    public function destroy(Post $post)
    {
        $deletedPost = $post->forceDelete();

        if (!$deletedPost){
            return  new JsonResponse([
                'errors' => [
                    'Could not delete the record'
                ]
            ], 400);
        }

        return  new  PostResource($deletedPost);
    }
}
