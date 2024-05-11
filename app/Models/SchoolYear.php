<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $primaryKey = 'sy_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['sy_id', 'sy_name','is_active'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}