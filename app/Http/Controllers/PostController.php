<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostSharedNotification;
use App\Repositories\PostRepository;
use App\Rules\InterArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;


/**
 * @group  Post Management
 *
 * APIs to manage the post resource.
 */

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * Gets a list of posts.
     * @queryParam page_size int Size per page. Defaults to 20. Example: 20
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\PostResource
     *@apiResourceModel App\Models\Post
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
     * @bodyParam title string required Title of the post. Example: Tourism Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is  for tourism"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param StorePostRequest $request
     * @param PostRepository $repository
     * @return PostResource
     */
    public function store(StorePostRequest $request, PostRepository $repository)
    {
        $postCreated = $repository->create($request->only([
            'title',
            'body',
            'user_ids',
        ]));

        $postCreated = $repository->create($postCreated);

        return  new PostResource($postCreated);
    }

    /**
     * Display the specified resource.
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return  new PostResource($post);
    }

    /**
     * Update the specified post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param UpdatePostRequest $request
     * @param \App\Models\Post $post
     * @param PostRepository $repository
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
     * Remove the specified post from storage.
     * @response 200 {
     * "data": "success"
     * }
     * @param \App\Models\Post $post
     * @param PostRepository $repository
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post, PostRepository $repository)
    {

        $deletedPost = $repository->forceDelete($post);
        return  new  JsonResponse([
            'data' =>'success'
        ]);
    }

    /**
     * Remove the specified post from storage.
     * @response 200 {
     * "data": "signed url..."
     * }
     * @param Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function share(Request $request, Post $post)
    {
        $url = URL::temporarySignedRoute('share.post', now()->addDay(30), [
            'post' => $post->id,
        ]);

        //array
        $users = User::query()->whereIn('id',$request->user_ids)->get();

        Notification::send($users, new PostSharedNotification($post, $url));

        $user = User::query()->find(1);
        $user->notify(new PostSharedNotification($post, $url));

        return  new  JsonResponse([
            'data' => $url

        ]);
    }
}
