<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StageCashierRequest extends FormRequest
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
        return [
         'invoice_reference' => 'required',
         'invoice_amount' => 'required',
         'reciept_reference' => 'required',
         'total_amount_paid' => 'required',
         'balance_to_be_paid' => 'required',
         'invoice' => 'required'
        ];
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
