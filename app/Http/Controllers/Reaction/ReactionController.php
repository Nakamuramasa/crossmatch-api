<?php

namespace App\Http\Controllers\Reaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReactionResource;
use App\Repositories\Contracts\IReaction;

class ReactionController extends Controller
{
    protected $reactions;

    public function __construct(IReaction $reactions)
    {
        $this->reactions = $reactions;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'to_user_id' => ['required'],
            'status' => ['required']
        ]);

        $reaction = $this->reactions->create([
            'to_user_id' => $request->to_user_id,
            'from_user_id' => auth()->id(),
            'status' => $request->status
        ]);

        return new ReactionResource($reaction);
    }
}
