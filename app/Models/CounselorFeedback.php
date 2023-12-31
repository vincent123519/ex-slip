<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// In CounselorFeedback model
class CounselorFeedback extends Model

{
    protected $table = 'counselor_feedbacks';

    protected $fillable = [
        'excuse_slip_id',
        'counselor_id',
        'remarks',
        // Add other fields as needed
    ];

    // Relationship with ExcuseSlip
    public function excuseSlip()
    {
        return $this->belongsTo(ExcuseSlip::class, 'excuse_slip_id');
    }
    

    // Relationship with Counselor
    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
