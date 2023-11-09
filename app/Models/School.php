<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $primaryKey = 'school_code';
    public $incrementing = false;
    protected $keyType = 'integer';
    
    protected $fillable = [
        'school_code',
        'school_name',
    ];

    /**
     * Define a one-to-many relationship with the Departments model.
     */
    public function departments()
    {
        return $this->hasMany(Department::class, 'school_code', 'school_code');
    }
    
    /**
     * Define an accessor to get the full name of the school.
     */
    public function getFullNameAttribute()
    {
        return 'School of ' . $this->school_name;
    }
}