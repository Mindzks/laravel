<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
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
        //need to check http method
        $method = $this->method();
        
        if($method =='PUT'){
            return [
                'name' => ['required'],
                'companyCode' => ['required'],
                'type' => ['required', Rule::in(['UAB','uab','VsI','vsi','VšĮ','všį'])],
                'email' => ['required'],
                'city' => ['required'],
                'postalCode' => ['required'],
                'address' => ['required']
            ];
        }else{
            return [
                'name' => ['sometimes','required'],
                'companyCode' => ['sometimes','required'],
                'type' => ['sometimes','required', Rule::in(['UAB','uab','VsI','vsi','VšĮ','všį'])],
                'email' => ['sometimes','required'],
                'city' => ['sometimes','required'],
                'postalCode' => ['sometimes','required'],
                'address' => ['sometimes','required']
            ];
        }
        
    }
    protected function prepareForValidation()
    {
        if($this->companyCode && $this->postalCode){
            $this->merge([
                'company_code' => $this->companyCode,
                'postal_code' => $this->postalCode
            ]);
        }elseif($this->postalCode){
            $this->merge([
                'postal_code' => $this->postalCode
            ]);
        }elseif($this->companyCode){
            $this->merge([
                'company_code' => $this->companyCode
            ]);
        }
    }
}
