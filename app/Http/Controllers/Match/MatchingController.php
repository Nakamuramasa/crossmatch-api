<?php

namespace App\Http\Controllers\Match;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\{
    IUser,
    IReaction
};

class MatchingController extends Controller
{
    protected $users;
    protected $reactions;

    public function __construct(IUser $users, IReaction $reactions)
    {
        $this->users = $users;
        $this->reactions = $reactions;
    }

    public function findMatchUser(){
        $got_reaction_ids = $this->reactions->gotReactionIds();
        $matching_ids = $this->reactions->matchingIds($got_reaction_ids);
        $matching_users = $this->users->matchingUsers($matching_ids);

        return UserResource::collection($matching_users);
    }
}
