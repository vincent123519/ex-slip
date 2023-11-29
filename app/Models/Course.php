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

    // Define the many-to-many relationship with students
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
