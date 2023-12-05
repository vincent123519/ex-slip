<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    protected $table = 'counselors';

    protected $primaryKey = 'counselor_id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'department_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}