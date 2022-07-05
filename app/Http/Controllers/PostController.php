<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
         $posts = Post::query()->get();

         return  new JsonResponse([
             'data' => $posts
         ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request)
    {
        //Post::query()->create($request->toArray());

        $postCreated = Post::query()->create([
            'title' => $request->title,
            'body'  => $request->body
        ]);

        return  new JsonResponse([
            'data' => $postCreated
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return  new JsonResponse([
            'data' =>$post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
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

       return  new  JsonResponse([
           'data' => $post
       ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
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

        return  new  JsonResponse([
            'data' => 'success'
        ]);
    }
}
