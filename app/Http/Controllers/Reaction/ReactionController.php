<?php

namespace App\Http\Controllers\Reaction;

use App\Models\Reaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReactionResource;
use App\Repositories\Contracts\IReaction;
use App\Repositories\Eloquent\Criteria\{
    LatestFirst,
    EagerLoad
};

class ReactionController extends Controller
{
    protected $reactions;

    public function __construct(IReaction $reactions)
    {
        $this->reactions = $reactions;
    }

    public function index()
    {
        $reactions = $this->reactions->withCriteria([
            new LatestFirst(),
        ])->all();
        return ReactionResource::collection($reactions);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'to_user_id' => ['required'],
            'status' => ['required']
        ]);

        $checkReaction = $this->reactions->alredyReaction([
            'to_user_id' => $request->to_user_id,
            'from_user_id' => auth()->id()
        ]);

        if($checkReaction->isEmpty()){
            $reaction = $this->reactions->create([
                'to_user_id' => $request->to_user_id,
                'from_user_id' => auth()->id(),
                'status' => $request->status
            ]);
            return new ReactionResource($reaction);
        }
    }

    public function update(Request $request, $id)
    {
        $reaction = $this->reactions->find($id);
        $this->authorize('update', $reaction);

        $this->validate($request, [
            'to_user_id' => ['required'],
            'status' => ['required']
        ]);

        $reaction = $this->reactions->update($id, [
            'to_user_id' => $request->to_user_id,
            'from_user_id' => auth()->id(),
            'status' => $request->status
        ]);

        return new ReactionResource($reaction);
    }

    public function destroy($id)
    {
        $reaction = $this->reactions->find($id);
        $this->authorize('delete', $reaction);
        $reaction->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }

    public function findById($id)
    {
        $reaction = $this->reactions->find($id);
        return new ReactionResource($reaction);
    }
}
