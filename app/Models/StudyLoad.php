<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyLoad extends Model
{
    protected $primaryKey = 'studyload_id';

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }

    public function courseOffering()
    {
        return $this->belongsTo(CourseOffering::class, 'offer_code');
    }
}