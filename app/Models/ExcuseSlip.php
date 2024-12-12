<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcuseSlip extends Model
{
    protected $primaryKey = 'excuse_slip_id';
    
    // Define the relationships
    // Inside ExcuseSlip model
    // ExcuseSlip.php (ExcuseSlip model)
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id'); // Assuming 'student_id' is the foreign key
    }

    public function degree()
    {

        return $this->belongsTo(DepartmentDegree::class, 'degree_id');
    }
    public function counselorFeedbacks()
    {
        return $this->hasMany(CounselorFeedback::class, 'excuse_slip_id');
    }
    public function deanFeedbacks()
    {
        return $this->hasMany(DeanFeedback::class, 'excuse_slip_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    public function counselor()
    {
        return $this->belongsTo(Counselor::class, 'counselor_id');
    }
    
    public function dean()
    {
        return $this->belongsTo(Dean::class, 'dean_id');
    }
    
    public function courses()
    {
        return $this->belongsTo(CourseOffering::class, 'offer_code', 'offer_code');
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
// In ExcuseSlip.php
public function courseOfferings()
{
    return $this->belongsToMany(CourseOffering::class, 'course_excuse_slip', 'excuse_slip_id', 'offer_code');
}
    
    // Define the fillable attributes
    protected $fillable = [
        'student_id',
        'counselor_id',
        'dean_id',
        'reason',
        'start_date',
        'end_date',
        'status_id',
    ];
}