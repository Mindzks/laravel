<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'personal_code',
        'city',
        'street',
        'house_number',
        'service_id'
    ];
    public function services(){
        return $this->belongsTo(Service::class);
    }
}
