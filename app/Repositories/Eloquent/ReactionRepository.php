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
}
