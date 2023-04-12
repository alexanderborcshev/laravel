<?php

namespace App\Http\Requests\Api\Provider;

use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;

class ProviderModeratorStoreRequest extends FormRequest
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
            'first_name'=>'required',
            'last_name'=>'required',
            'second_name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'form_business'=>'required',
            'name'=>'required',
            'site'=>'required',
            'description'=>'required',
            'legal_entity'=>'required',
            'inn'=>'required',
            'ogrn'=>'required',
            'kpp'=>'required',
            'checking_account'=>'required',
            'bank'=>'required',
            'bik'=>'required',
            'ur_address'=>'required',
            'post_address'=>'required',
            'work_time'=>'required',
            'work_time_start'=>'required',
            'work_time_end'=>'required',
        ];
    }
}
