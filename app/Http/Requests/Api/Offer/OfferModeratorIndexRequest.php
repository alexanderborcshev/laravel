<?php

namespace App\Http\Requests\Api\Offer;

use App\Models\Offer;
use Illuminate\Foundation\Http\FormRequest;

class OfferModeratorIndexRequest extends FormRequest
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
            'status'=>'required',
        ];
    }
}
