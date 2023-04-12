<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * @property string login
     * @property string password
     */
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'login'=> 'required',
            'password'=> 'required|max:4|min:4'
        ];
    }

    public function getValidatorInstance(): Validator
    {
        $this->cleanPhoneNumber();
        return parent::getValidatorInstance();
    }

    protected function cleanPhoneNumber()
    {
        if($this->request->has('login')){
            $this->merge([
                'login' => str_replace(['-','_','','+','(',')'], '', $this->request->get('login'))
            ]);
        }
    }
}
