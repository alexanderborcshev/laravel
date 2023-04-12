<?php

namespace App\Http\Requests\Api\Order;

use App\Models\Offer;
use Illuminate\Foundation\Http\FormRequest;

class OrderProviderListRequest extends FormRequest
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
            'status'=>'required',
            'direction'=>'',
            'offer'=>'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['status' => $this->route('status')]);
    }
}
