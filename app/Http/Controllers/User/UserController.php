<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;

class UserController extends Controller
{
    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->all();
        return UserResource::collection($users);
    }

    public function findById($id)
    {
        $user = $this->users->findOrFail($id);
        return new UserResource($user);
    }

    public function findByUsername($username)
    {
        $user = User::findOrFail($username);
        return new UserResource($user);
    }
}
