<?php

namespace App\Http\Requests\Api\Accountant;

use App\Models\Bill;
use Illuminate\Foundation\Http\FormRequest;

class ShowBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->canany(['moderator','accountant','provider_owner'], Bill::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id'=>'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('bill')]);
    }
}
