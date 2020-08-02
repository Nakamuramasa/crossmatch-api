<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_img' => $this->user_img,
            'username' => $this->username,
            'email' => $this->email,
            'name' => $this->name,
            'about' => $this->about,
            'sex'=> $this->sex,
            'location' => $this->location,
            'formatted_address' => $this->formatted_address,
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}
