<?php

namespace App\Http\Requests\Api\Manager;

use App\Models\Manager;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ManagerProviderBlockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('provider_owner', Manager::class);
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
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('manager')]);
    }
}
