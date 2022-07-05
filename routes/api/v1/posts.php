<?php


use Illuminate\Support\Facades\Route;


Route::middleware([
  //'auth'
])
    ->prefix('test')
    ->name('posts.')
    ->namespace("\App\Http\Controllers")
    ->group(function (){

        Route::get('/posts',            [\App\Http\Controllers\PostController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');;
        Route::get('/posts/{post}',     [\App\Http\Controllers\PostController::class, 'show'])
            ->name('show')
            ->where('post','[0-9]+');
        Route::post('/posts',           [\App\Http\Controllers\PostController::class, 'store'])->name('store');
        Route::patch('/posts/{post}',   [\App\Http\Controllers\PostController::class, 'update'])->name('update');
        Route::delete('/posts/{post}',  [\App\Http\Controllers\PostController::class, 'destroy'])->name('destroy');
    });
