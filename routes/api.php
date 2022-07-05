<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/users', function (Request $request){
    //dump($request);

   return new \Illuminate\Http\JsonResponse([
       'data' => 'aaasss'
   ]);
});


Route::get('/users/{$user}', function (\App\Models\User $user){
    return new \Illuminate\Http\JsonResponse([
        'data' => $user
    ]);
});


Route::post('/users', function (){
    return new \Illuminate\Http\JsonResponse([
        'data' => 'posted'
    ]);

});


Route::patch('/users/{user}', function (\App\Models\User $user){
    return new \Illuminate\Http\JsonResponse([
        'data' => "patched"
    ]);

});


Route::delete('/users/{user}', function (\App\Models\User $user){

    return new \Illuminate\Http\JsonResponse([
        'data' => "deleted"
    ]);
});






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
