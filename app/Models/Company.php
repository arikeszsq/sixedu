<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table = 'company';

    public function children()
    {
        return $this->hasMany(CompanyChild::class, 'company_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(CompanyCourse::class, 'company_id', 'id');
    }
}
