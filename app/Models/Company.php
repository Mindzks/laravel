<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_code',
        'type',
        'email',
        'city',
        'postal_code',
        'address'
    ];

    public function services(){
        return $this->hasMany(Service::class, 'company_id');
    }

    public static function companyExists($id){
        $temp = Company::find($id);
        
    }

}
