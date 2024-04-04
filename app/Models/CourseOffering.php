<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOffering extends Model
{
    use HasFactory;

    protected $primaryKey = 'offer_code'; // Specify the primary key
    protected $table = 'course_offerings';


    
    protected $fillable = [
        'offer_code',
        'course_code',
        'semester_id',
        'teacher_id',
        'start_time',
        'end_time',
        'days_of_week',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    
    public function studyLoads()
    {
        return $this->belongsToMany(StudyLoad::class, 'study_load_course_offerings', 'offer_code', 'study_load_id');
    }


}
