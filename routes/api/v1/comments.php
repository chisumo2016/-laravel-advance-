<?php

//Route::apiResource('users',  \App\Http\Controllers\UserController::class);

use Illuminate\Support\Facades\Route;


Route::middleware([
//    'auth'
        ])
    ->prefix('test')
    ->name('comments.')
    ->namespace("\App\Http\Controllers")
    ->group(function (){

    Route::get('/comments',            [\App\Http\Controllers\CommentController::class, 'index'])
        ->name('index')
        ->withoutMiddleware('auth');;
    Route::get('/comments/{comment}',     [\App\Http\Controllers\CommentController::class, 'show'])
        ->name('show')
        ->where('comment','[0-9]+');
    Route::post('/comments',           [\App\Http\Controllers\CommentController::class, 'store'])->name('store');
    Route::patch('/comments/{comment}',   [\App\Http\Controllers\CommentController::class, 'update'])->name('update');
    Route::delete('/comments/{comment}',  [\App\Http\Controllers\CommentController::class, 'destroy'])->name('destroy');
});


