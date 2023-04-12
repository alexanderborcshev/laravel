<?php

namespace App\Http\Resources\Api\User;

use App\Models\Bill;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Offer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use JsonSerializable;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $groupsCodes = [];
        $groups = $this->groups;
        foreach ($groups as $item) {
            $groupsCodes[$item->code] = true;
        }
        $manager = $this->managers()->first();
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'second_name' => $this->second_name,
            'last_name'   => $this->last_name,
            'email' => $this->email,
            'phone'   => $this->phone,
            'login'   => $this->login,
            'login_to_phone'   => $this->login_to_phone,
            'groups'   => UserGroupResource::collection($groups),
            'groupsCodes'   => $groupsCodes,
            'manager'   => $manager,
        ];
        if ($this->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $manager->owner) {
            $provider_id = $manager->provider_id;
            $offer = Offer::where('provider_id', $provider_id)
                ->where('status', OfferStatusEnum::wait_public->name)
                ->first();
            if ($offer) {
                $result['offer_redirect'] = $offer->id;
            }
            $act = Bill::where('provider_id', $provider_id)
                ->where('accept_date', null)
                ->first();
            if ($act) {
                $result['bill_redirect'] = $act->id;
            }
        }



        return $result;
    }
}
