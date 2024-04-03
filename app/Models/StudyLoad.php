<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudyLoad extends Model
{
    protected $primaryKey = 'studyload_id';
    protected $table = 'study_loads';

    protected $fillable = ['student_id', 'semester_id'];


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

   
    public function studyLoad()
        {
            return $this->hasOne(StudyLoad::class, 'student_id');
        }
   public function courseOfferings()
   {
       return $this->belongsToMany(CourseOffering::class, 'study_load_course_offerings', 'study_load_id', 'offer_code');
   }

}