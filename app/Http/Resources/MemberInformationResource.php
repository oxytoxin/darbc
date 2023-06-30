<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'darbc_id' => $this->darbc_id,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'contact_number' => $this->contact_number,
            'user' => UserResource::make($this->whenLoaded('user')),
            'active_restriction' => RestrictionResource::make($this->user?->active_restriction),
            'holographic' => $this->holographic,
        ];
    }
}
