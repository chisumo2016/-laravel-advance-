<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $comments = Comment::query()->get();

        return  CommentResource::collection($comments);


        /*return  new JsonResponse([
            'data' => $comments
        ]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request)
    {
        $commentCreated = Comment::query()->create([
                //'title' => $request->title,
                'body'  =>  $request->body
        ]);

        return  new CommentResource($commentCreated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return CommentResource
     */
    public function show(Comment $comment)
    {
        return  new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return CommentResource |  JsonResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $updateComment = $comment->update([
            //'title'       =>  $request->title    ??   $comment->title,
            'body'        =>  $request->body     ??   $comment->body,

        ]);

        if (!$updateComment){
            return  new JsonResponse([
                'errors' => [
                    'Failed to updated the record model'
                ]
            ], 400);
        }

        return  new  CommentResource($updateComment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
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
