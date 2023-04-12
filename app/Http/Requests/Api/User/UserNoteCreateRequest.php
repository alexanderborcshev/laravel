<?php

namespace App\Http\Requests\Api\User;

use App\Models\Order;
use App\Models\UserNote;
use Illuminate\Foundation\Http\FormRequest;

class UserNoteCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', UserNote::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'comment' => 'required',
            'user_id' => 'required',
        ];
    }
}
