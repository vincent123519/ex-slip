<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dean extends Model
{
    protected $primaryKey = 'dean_id';
    protected $fillable = ['user_id', 'name', 'school_code', 'department_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_code');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}