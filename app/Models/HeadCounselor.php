<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadCounselor extends Model
{
    protected $table = 'head_counselors';

    protected $primaryKey = 'head_counselor_id';

    protected $fillable = [
        'user_id', // Remove 'head_counselor_id' from fillable
        'name',
        'department_id',
    ];
    


    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}