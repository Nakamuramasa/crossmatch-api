<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'to_user_id' => $this->to_user_id,
            'from_user_id' => $this->from_user_id,
            'to_user_detail' => new UserResource($this->toUserId),
            'from_user_detail' => new UserResource($this->fromUserId),
            'status' => $this->status
        ];
    }
}
