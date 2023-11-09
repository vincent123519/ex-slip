<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcuseStatus extends Model
{
    protected $table = 'excuse_statuses';
    protected $primaryKey = 'status_id';
    public $incrementing = false;
    protected $fillable = [
        'status_name',
    ];

    // Relationships
    public function excuseSlips()
    {
        return $this->hasMany(ExcuseSlip::class, 'status_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'status_id');
    }
}