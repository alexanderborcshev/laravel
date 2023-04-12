<?php

namespace App\Http\Requests\Api\Offer;

use App\Models\Offer;
use Illuminate\Foundation\Http\FormRequest;

class OfferProviderListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('provider_owner', Offer::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [];
    }
}
