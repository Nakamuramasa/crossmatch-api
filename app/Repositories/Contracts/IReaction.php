<?php

namespace App\Repositories\Contracts;

interface IReaction
{
    public function alredyReaction(array $data);
    public function gotReactionIds();
    public function matchingIds(array $reactionId);
}
