<?php

namespace App\Http\Requests;

use App\Models\StageCashier;
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
        $rules = [
            'invoice_reference' => 'required',
            'invoice_amount' => 'required',
            'total_amount_paid' => 'required',
            'balance_to_be_paid' => 'required',
            'process_id' => 'required',
        ];

        // Check if the invoice doesn't exist in the database
        if (!$this->invoiceExistsInDatabase()) {
            $rules['invoice'] = 'required';
        }

        if($this->input('total_amount_paid')>0){
            $rules['reciept_reference'] = 'required';
        }

        return $rules;
    }

    protected function invoiceExistsInDatabase()
    {
        return StageCashier::where('id', $this->input('process_id'))->exists();
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
