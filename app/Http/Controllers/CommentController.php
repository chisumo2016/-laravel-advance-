<?php
declare(strict_types =1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $comments = Comment::query()->get();

        return  new JsonResponse([
            'data' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request)
    {
        $commentCreated = Comment::query()->create([
                //'title' => $request->title,
                'body'  =>  $request->body
        ]);

        return  new JsonResponse([
            'data' => $commentCreated
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return JsonResponse
     */
    public function show(Comment $comment)
    {
        return  new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
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

        return  new  JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
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

        return  new  JsonResponse([
            'data' => 'success'
        ]);

    }
}
