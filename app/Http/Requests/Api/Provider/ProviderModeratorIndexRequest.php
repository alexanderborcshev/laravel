<?php

namespace App\Http\Requests\Api\Provider;

use App\Models\Offer;
use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;

class ProviderModeratorIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('moderator', Provider::class);
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
