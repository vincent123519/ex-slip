<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeanFeedback extends Model
{
    use HasFactory;

    protected $table = 'dean_feedbacks';

    protected $fillable = [
        'excuse_slip_id',
        'dean_id',
        'remarks',
        // Add other fields as needed
    ];

    // Relationships with ExcuseSlip and Dean
    public function excuseSlip()
    {
        return $this->belongsTo(ExcuseSlip::class, 'excuse_slip_id');
    }

    public function dean()
    {
        return $this->belongsTo(User::class, 'dean_id');
    }
}
