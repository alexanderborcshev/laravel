<?php

namespace App\Http\Resources\Api\Provider;

use App\Http\Resources\Api\Offer\OfferForProviderListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDetailResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'legal_entity' => $this->legal_entity,
            'inn' => $this->inn,
            'ogrn' => $this->ogrn,
            'site' => $this->site,
            'work_time' => $this->work_time,
            'work_time_start' => $this->work_time_start,
            'work_time_end' => $this->work_time_end,
            'status' => $this->status,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'kpp' => $this->kpp,
            'checking_account' => $this->checking_account,
            'bik' => $this->bik,
            'bank' => $this->bank,
            'ur_address' => $this->ur_address,
            'post_address' => $this->post_address,
            'form_business' => $this->form_business,
            'need_email' => $this->need_email,
            'contract_date' => $this->contract_date_only,
        ];
    }
}
