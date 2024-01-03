<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherFeedback extends Model
{
    use HasFactory;

    protected $table = 'teacher_feedbacks';

    protected $fillable = [
        'excuse_slip_id',
        'teacher_id',
        'remarks',
        // Add other fields as needed
    ];

    // Relationships with ExcuseSlip and Teacher
    public function excuseSlip()
    {
        return $this->belongsTo(ExcuseSlip::class, 'excuse_slip_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
