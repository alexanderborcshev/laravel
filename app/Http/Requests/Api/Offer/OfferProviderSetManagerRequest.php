<?php

namespace App\Http\Requests\Api\Offer;

use App\Models\Offer;
use Illuminate\Foundation\Http\FormRequest;

class OfferProviderSetManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $offer = Offer::find($this->offer);
        return $offer && $this->user()->can('provider', $offer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id'=>'required|numeric',
            'manager_id'=>'required|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('offer')]);
    }
}
