<?php

namespace App\Http\Requests\Api\Accountant;

use App\Models\Bill;
use Illuminate\Foundation\Http\FormRequest;

class BillModeratorIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->canany(['moderator','accountant'], Bill::class);
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
