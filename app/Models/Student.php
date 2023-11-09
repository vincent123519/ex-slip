<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'user_id',
        'name',
        'degree_id',
        'year_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function degree()
    {
        return $this->belongsTo(DepartmentDegree::class, 'degree_id');
    }
}