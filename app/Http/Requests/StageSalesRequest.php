<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StageSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'customer_id' => 'required',
            'key_products' => 'required',
            'user_id' => 'required',
            'nr_sheets' => 'required',
            'nr_panels' => 'required',
            'order_value' => 'required',
            'estimated_process_time' => 'required',
            'date_required' => 'required',
            'priority_level' => 'required',
            'order_confirmation' => 'required',
        ];

        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
