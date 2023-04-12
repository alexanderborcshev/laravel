<?php

namespace App\Http\Resources\Api\Provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderFoBillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => str_replace('+7', '8', $this->phone),
            'legal_entity' => $this->legal_entity,
            'user_name' => $this->managers()->first()?->user?->name,
            'form_business' => $this->form_business,
        ];
    }
}
