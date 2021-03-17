<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
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
            'users_id' => $this->users_id,
            'username' => $this->username,
            'life' => $this->life,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'health' => $this->health,
            'gold' => $this->gold,
            'ruby' => $this->ruby
        ];
    }
}
