<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app', function () {
    return view('app');
});


Route::get('/reset-password/{token}', function ($token){
    return view('auth.password-reset', [
        'token' => $token
    ]);
})->middleware(['guest:'.config('fortify.guard')])
    ->name('password.reset');

if (\Illuminate\Support\Facades\App::environment('local')){

//     Lang::setLocale('es');
//    App::setLocale('es');
//    $trans = Lang::get('auth.failed');
//
//    $trans = __('auth.password') ;
//    $trans = __('auth.throttle', ['seconds' => 5]) ;
//
//    /** Current locale*/
//    dump(\Illuminate\Support\Facades\App::currentLocale());
//    dump(App::isLocal('en'));
//
//    $trans = __('tannzania') ;
//    $trans = trans_choice('auth.pants', 1);
//    $trans = trans_choice('auth.apples', -1,['baskets'=>2]);
//    $trans = __('auth.welcome', ['name' => 'sam']);
//
//    dd($trans);*

    Route::get('/shared/posts/{post}' , function (\Illuminate\Http\Request $request, \App\Models\Post $post){
        return  "Specially made just for you Post Post ID :{$post->id}";

    })->name('share.post')->middleware('signed');

    Route::get('/shared/videos/{video}' , function (\Illuminate\Http\Request $request, $video){
        if (!$request->hasValidSignature()){
            abort(401);
        }

        return 'good';
    })->name('share.video');

    Route::get('/playground', function () {

        event(new  \App\Events\ChatMessageEvent());

        //$url = URL::temporarySignedRoute('share.video',now()->addSeconds(30),['video' => 123]);
        //return $url;
        return null;
    });


    Route::get('/playground2', function () {
       $user = \App\Models\User::factory()->make();
        \Illuminate\Support\Facades\Mail::to($user)
            ->send(new \App\Mail\WelcomeMail($user));
        return null;
    });

    Route::get('/ws', function (){
        return view('websocket');
    });

    Route::post('/chat-message',function (\Illuminate\Http\Request $request) {
            event(new \App\Events\ChatMessageEvent($request->message, auth()->user()));
            return null ;
    });
}



