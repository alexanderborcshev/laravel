<?php

namespace App\Http\Resources\Public\Provider;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderModalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'api_key' => $this->api_key,
            'legal_entity' => $this->legal_entity,
            'work_time_full' => $this->work_time . ' c '. $this->work_time_start. ' до '.$this->work_time_end,
            'inn' => $this->inn,
            'ogrn' => $this->ogrn,
            'site' => $this->site,
            'need_email' => $this->need_email,
            'status' => $this->status,
        ];
    }
}
