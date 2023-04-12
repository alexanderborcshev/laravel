<?php

namespace App\Http\Requests\Api\Auth;
class AuthCheckLoginRequest extends AuthRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'login'=> 'required|max:12|min:10'
        ];
    }
}
