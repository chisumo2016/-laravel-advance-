<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Comment Management
 * APIs to manage comments
 */

class CommentController extends Controller
{
    /**
     * Display a listing of comments.
     *
     * Gets a list of comments.
     *
     * @queryParam page_size int Size per page. Defaults to 20. Example: 20
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Comment
     * @return ResourceCollection
     */
    public function index()
    {
        //$comments = Comment::query()->get();

        $comments = Comment::query()->paginate($request->page_size ?? 20);

        return  CommentResource::collection($comments);


        /*return  new JsonResponse([
            'data' => $comments
        ]);*/
    }

    /**
     * Store a newly created comment in storage.
     * @bodyParam body string[] required Body of the comment. Example: ["This comment is super beautiful"]
     * @bodyParam user_id int required The author id of the comment. Example: 1
     * @bodyParam post_id int required The post id that the comment belongs to. Example: 1
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     * @param \Illuminate\Http\Request $request
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request, CommentRepository $repository)
    {
        $commentCreated = $repository->create($request->only([
            'body',
            'user_id',
            'post_id',
        ]));
        return  new CommentResource($commentCreated);
    }

    /**
     * Display the specified comment.
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     * @param \App\Models\Comment $comment
     * @return CommentResource
     */
    public function show(Comment $comment)
    {
        return  new CommentResource($comment);
    }

    /**
     * Update the specified comment in storage.
     * @bodyParam body string[] Body of the comment. Example: ["This comment is super beautiful"]
     * @bodyParam user_id int The author id of the comment. Example: 1
     * @bodyParam post_id int The post id that the comment belongs to. Example: 1
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     * @param UpdateCommentRequest $request
     * @param \App\Models\Comment $comment
     * @param UserRepository $repository
     * @return CommentResource | JsonResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment, UserRepository $repository)
    {
        $updateComment = $repository->update($comment, $request->only([
            'body',
            'user_id',
            'post_id',
        ]));
        return  new  CommentResource($updateComment);
    }

    /**
     * Remove the specified comment from storage.
     * @response 200 {
    "data": "success"
     * }
     * @param \App\Models\Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment)
    {
        $deletedComment = $comment->forceDelete();

        if (!$deletedComment){
            return  new JsonResponse([
                'errors' => [
                    'Could not delete the record'
                ]
            ], 400);
        }

        //return  new  CommentResource($deletedComment);

        return  new  JsonResponse([
            'data' => 'success'
        ]);

    }
}
