<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'user_id',
        'name',
        'department_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function courseOfferings()
    {
        return $this->hasMany(CourseOffering::class, 'teacher_id');
    }

    public function excuseSlips()
    {
        return $this->hasMany(ExcuseSlip::class, 'teacher_id');
    }
}