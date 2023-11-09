<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentDegree extends Model
{
    protected $primaryKey = 'degree_id';
    
    protected $fillable = [
        'department_id',
        'degree_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}