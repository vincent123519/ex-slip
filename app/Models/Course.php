<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'course_code';
    public $incrementing = false;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function courseOfferings()
    {
        return $this->hasMany(CourseOffering::class, 'course_code', 'course_code');
    }
}