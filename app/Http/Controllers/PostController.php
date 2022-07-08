<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Rules\InterArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
         $pageSize = $request->page_size ?? 20;
         $posts = Post::query()->paginate($pageSize);

         return  PostResource::collection($posts);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return PostResource
     */
    public function store(Request $request, PostRepository $repository)
    {
        $payLoad = $request->only([
            'title',
            'body',
            'user_ids',
        ]);

        $validator = Validator::make($payLoad, [
                'title'     => 'string|required',
                'body'      => ['string','required'],
                'user_ids'  => [
                    'array',
                    'required',
                    new InterArray(),
            ]
        ],

        [
            'body.required' => 'Please enter a value for body',
            'title.string'  => 'Heyy use a string'
        ],
        [
           'user_ids' =>"User IOOO"
        ]);



        $validator->validate();

        $postCreated = $repository->create($payLoad);

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
    public function update(UpdatePostRequest $request, Post $post, PostRepository $repository)
    {
        $updatePost = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids',
        ]));
       return  new  PostResource($updatePost);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostRepository $repository)
    {

        $deletedPost = $repository->forceDelete($post);
        return  new  JsonResponse([
            'data' =>'success'
        ]);
    }
}
