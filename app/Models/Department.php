<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_name',
        'school_code',
    ];

    /**
     * Define a many-to-one relationship with the School model.
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_code');
    }

    /**
     * Define a one-to-many relationship with the HeadCounselor model.
     */
    public function headCounselors()
    {
        return $this->hasMany(HeadCounselor::class, 'department_id');
    }

    /**
     * Define a one-to-many relationship with the Teacher model.
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'department_id');
    }

    /**
     * Define a one-to-many relationship with the Counselor model.
     */
    public function counselors()
    {
        return $this->hasMany(Counselor::class, 'department_id');
    }

    /**
     * Define a one-to-many relationship with the Dean model.
     */
    public function deans()
    {
        return $this->hasMany(Dean::class, 'department_id');
    }

    /**
     * Define a one-to-many relationship with the DepartmentDegree model.
     */
    public function departmentDegrees()
    {
        return $this->hasMany(DepartmentDegree::class, 'department_id');
    }

    /**
     * Define a one-to-many relationship with the Course model.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }

    /**
     * Define a one-to-many relationship with the CourseOffering model.
     */
    public function courseOfferings()
    {
        return $this->hasMany(CourseOffering::class, 'department_id');
    }
}