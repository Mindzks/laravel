<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'companyCode' => ['required'],
            'type' => ['required', Rule::in(['UAB','uab','VsI','vsi','VšĮ','všį'])],
            'email' => ['required'],
            'city' => ['required'],
            'postalCode' => ['required'],
            'address' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'company_code' => $this->companyCode,
            'postal_code' => $this->postalCode
        ]);
    }

}
