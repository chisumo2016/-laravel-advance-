<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $users = User::query()->get();

        return  UserResource::collection($users);

        /*return  new JsonResponse([
            'data' => $users
        ]);*/
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
     * @return UserResource | JsonResponse
     */
    public function store(Request $request, UserRepository $repository)
    {
        $UserCreated = $repository->create($request->only([
            'name',
            'email',
            'password',
        ]));

        return  new  UserResource($UserCreated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return UserResource| JsonResponse
     */
    public function show(User $user)
    {
        return  new UserResource($user);
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
     * @return UserResource | JsonResponse
     */
    public function update(Request $request, User $user ,UserRepository $repository)
    {
        $updateUser = $repository->update($user,$request->only([
            'name',
            'email',
        ]));

        return  new  UserResource($updateUser);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return UserResource |JsonResponse
     */
    public function destroy(User $user, UserRepository $repository)
    {
        $deletedUser = $repository->forceDelete($user);

        return new JsonResponse([
            'data' => 'success',
        ]);

    }
}
