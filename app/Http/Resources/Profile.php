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
            'citizens' => $this->citizens,
            'horses' => $this->horses,
            'golds' => $this->golds,
            'food' => $this->food,
            'wood' => $this->wood,
            'stone' => $this->stone,
            'ruby' => $this->ruby
        ];
    }
}
