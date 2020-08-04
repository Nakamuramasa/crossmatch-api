<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function findById($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return new UserResource($user);
    }

    public function findByUsername($username)
    {
        $user = User::where('username', $username)->get();
        return new UserResource($user);
    }
}
