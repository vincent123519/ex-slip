<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcuseSlip extends Model
{
    protected $primaryKey = 'excuse_slip_id';
    
    // Define the relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }
    
    public function dean()
    {
        return $this->belongsTo(Dean::class, 'dean_id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_code', 'course_code');
    }
    
    public function status()
    {
        return $this->belongsTo(ExcuseStatus::class, 'status_id');
    }
    
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'excuse_slip_id');
    }
    
    public function supportingDocuments()
    {
        return $this->hasMany(SupportingDocument::class, 'excuse_slip_id');
    }
    
    // Define the fillable attributes
    protected $fillable = [
        'student_id',
        'teacher_id',
        'counselor_id',
        'dean_id',
        'course_code',
        'reason',
        'start_date',
        'end_date',
        'status_id',
    ];
}