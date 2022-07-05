<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::query()->get();

        return  new JsonResponse([
            'data' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $UserCreated = User::query()->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password
        ]);

        return  new JsonResponse([
            'data' => $UserCreated
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return  new JsonResponse([
            'data' =>$user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $updateUser = $user->update([
            'name'      =>  $request->name      ?? $user->name,
            'email'     =>  $request->email     ?? $user->email,
            'password'  =>  $request->password  ?? $user->password,
        ]);

        if (!$updateUser){
            return  new JsonResponse([
                'errors' => [
                    'Failed to updated the record model'
                ]
            ], 400);
        }

        return  new  JsonResponse([
            'data' => $user
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $deletedUser = $user->forceDelete();

        if (!$deletedUser){
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
