<?php

namespace App\Repositories\Eloquent;

use App\Models\Reaction;
use App\Repositories\Contracts\IReaction;
use App\Repositories\Eloquent\BaseRepository;

class ReactionRepository extends BaseRepository implements IReaction
{
    public function model()
    {
        return Reaction::class;
    }

    public function alredyReaction(array $data)
    {
        return $this->model->where($data)->get();
    }

    public function gotReactionIds()
    {
        return $this->model->where([
            ['to_user_id', auth()->id()],
            ['status', 0]
        ])->pluck('from_user_id')->all();
    }

    public function matchingIds(array $reactionId)
    {
        return $this->model->whereIn('to_user_id', $reactionId)->where([
                ['from_user_id', auth()->id()],
                ['status', 0]
        ])->pluck('to_user_id')->all();
    }
}
