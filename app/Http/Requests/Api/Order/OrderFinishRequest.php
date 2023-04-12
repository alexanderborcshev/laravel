<?php

namespace App\Http\Requests\Api\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderFinishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $order = Order::find($this->route('id'));
        return $order && $this->user()->can('status', $order);
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
            'comment'=>'required',
            'price'=>'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }
}
