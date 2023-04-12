<?php

namespace App\Http\Requests\Api\Order;

use App\Models\Offer;
use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $provider = Provider::where('api_key', $this->get('api_key'))->first();
        $offer = Offer::find($this->get('offer_id'));
        return $provider && $offer && $offer->provider_id == $provider->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'api_key'=>'required',
            'offer_id'=>'required|numeric',
            'phone'=>'required',
            'name'=>'required',
            'email'=>'',
            'comment'=>'required',
            'how_connect'=>'',
        ];
    }
}
