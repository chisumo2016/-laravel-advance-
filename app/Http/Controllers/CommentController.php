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
        return new \Illuminate\Http\JsonResponse([
            'data' => 'aaasss'
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
        return new \Illuminate\Http\JsonResponse([
            'data' => 'posted'
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
        return new \Illuminate\Http\JsonResponse([
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
        return new \Illuminate\Http\JsonResponse([
            'data' => "patched"
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
        return new \Illuminate\Http\JsonResponse([
            'data' => "deleted"
        ]);
    }
}
