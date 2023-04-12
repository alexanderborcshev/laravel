<?php

namespace App\Http\Requests\Api\Accountant;

use App\Models\Bill;
use Illuminate\Foundation\Http\FormRequest;

class BillProviderIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(['provider_owner'], Bill::class);
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
