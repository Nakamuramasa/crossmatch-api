<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\{
    LatestFirst,
    WithoutMe,
    EagerLoad
};

class UserController extends Controller
{
    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->withCriteria([
            new LatestFirst(),
            new WithoutMe(),
            // new EagerLoad(['fromUserId'])
        ])->all();
        return UserResource::collection($users);
    }

    public function findUser($id)
    {
        $user = $this->users->find($id);
        return new UserResource($user);
    }

    public function findByUsername($username)
    {
        dd($username);exit;
        $user = $this->users->findWhereFirst('username', $username);
        return new UserResource($user);
    }
}
