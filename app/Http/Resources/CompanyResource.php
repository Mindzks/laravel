<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'companyCode' => $this->company_code,
            'type' => $this->type,
            'email' => $this->email,
            'city' => $this->city,
            'postalCode' => $this->postal_code,
            'address' => $this->address
        ];
    }
}
