<?php

namespace App\Http\Requests\Api\Offer;

use App\Models\Offer;
use Illuminate\Foundation\Http\FormRequest;

class OfferModeratorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('moderator', Offer::class);
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
            'offerName'=>'required',
            'category'=>'required',
            'minCheck'=>'required',
            'maxCheck'=>'required',
            'commission'=>'required',
            'promo'=>'required',
            'gift1'=>'required',
            'gift2'=>'required',
            'gift3'=>'required',
            'gift4'=>'',
            'mainTextBlockTitle'=>'required',
            'mainTextBlock'=>'required',
            'textBlocks'=>'required',
            'pricesList'=>'required',
            'photos'=>'required',
            'mainPhoto'=>'required',
            'advantagesTextBlock'=>'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('offer')]);
    }
}
