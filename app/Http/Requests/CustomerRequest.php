<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        // Determine if the 'id_number' should be unique based on 'save_action' value
        $uniqueRule = $this->input('save_action') === 'save_and_preview'
            ? Rule::unique('customers')->where(function ($query) {
                return $query->where('id_type', $this->id_type);
            })
            : '';

        return [
            'name' => 'required|min:5|max:255',
            'customer_category_id' => 'required',
            'id_type' => 'required',
            'id_number' => [
                'required',
               $uniqueRule,
            ],
            'phone' => 'required',
            'address' => 'required',
            'tax_number' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required'
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
