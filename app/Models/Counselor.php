<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    protected $table = 'counselors'; // Specify the table name

    protected $primaryKey = 'counselor_id'; // Specify the primary key
    public $timestamps = false; // Disable timestamps if not used

    protected $fillable = [
        'user_id', // Remove counselor_id from fillable if it's auto-incrementing
        'first_name',
        'last_name',
        'department_id',
        'email',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship to the Department model
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}