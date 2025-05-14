<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $primaryKey = 'semester_id';
    protected $table = 'semesters';

    protected $fillable = [
        'semester_name',
        'sy_id',
        'is_active',
    ];

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'sy_id');
    }
}