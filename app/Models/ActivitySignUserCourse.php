<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActivitySignUserCourse extends Model
{
    protected $table = 'activity_sign_user_course';

    public function school()
    {
        return $this->hasOne(CompanyChild::class, 'id', 'school_id');
    }

    public function course()
    {
        return $this->hasOne(CompanyCourse::class, 'id', 'course_id');
    }
}
