<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'last_login_at' => $this->last_login_at?->toDayDateTimeString(),
            'is_active' => ($this->is_active) ? true : false,
            'avatar' => $this->avatar,
            'email_verified' => ($this->email_verified_at) ? true : false,
        ];

        return $data;
    }
}
