<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'excuse_slip_id',
        'feedback_remarks',
        'feedback_date',
        'sender_id',
        'feedback_type',
    ];

    public function excuseSlip()
    {
        return $this->belongsTo(ExcuseSlip::class, 'excuse_slip_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}