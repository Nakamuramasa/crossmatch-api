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
            'user_img' => $this->images,
            'username' => $this->username,
            'name' => $this->name,
            $this->mergeWhen(auth()->check() && auth()->id() === $this->id, [
                'email' => $this->email,
            ]),
            'about' => $this->about,
            'sex'=> $this->sex,
            'location' => $this->location,
            'formatted_address' => $this->formatted_address,
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'update_dates' => [
                'updated_at_human' => $this->updated_at->diffForHumans(),
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
