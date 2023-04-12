<?php

namespace App\Http\Resources\Api\Accountant;

use App\Http\Resources\Api\Provider\ProviderFoBillResource;
use App\Http\Resources\Api\User\UserBaseInfoResource;
use App\Http\Resources\Public\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BillDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'status' => $this->status,
            'provider' => new ProviderFoBillResource($this->provider),
            'sum' => $this->sum,
            'profit' => $this->profit,
            'number' => $this->number,
            'file_act' => new FileResource($this->file_act),
            'file_report' => new FileResource($this->file_report),
            'file_bill' => new FileResource($this->file_bill),
            'send' => $this->send,
            'accept_date' => $this->accept_date_only,
            'created_date_diff' => $this->created_date_diff,
            'created_date_text' => $this->created_date_text,
            'created_day_diff' => $this->created_day_diff,
            'accept_user' => new UserBaseInfoResource($this->accept_user),
            'used_date' => $this->used_date_only,
            'created_date' => $this->created_date,
        ];
    }
}
