<?php

namespace App\Http\Requests\Api\Manager;

use App\Models\Manager;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ManagerProviderStoreRequest extends FormRequest
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
            'name'=>'required',
            'second_name'=>'required',
            'last_name'=>'required',
            'phone'=>'required',
            'login'=>'required',
            'email'=>'required',
        ];
    }

    public function getValidatorInstance(): Validator
    {
        $this->cleanPhoneNumber();
        return parent::getValidatorInstance();
    }

    protected function cleanPhoneNumber()
    {
        $this->merge([
            'login' => str_replace(['-','_','','+','(',')'], '', $this->request->get('phone'))
        ]);
    }
}
