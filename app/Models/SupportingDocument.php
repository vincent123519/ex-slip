<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportingDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'document_id';

    protected $fillable = [
        'excuse_slip_id',
        'document_path',
        'upload_date',
    ];

    public function excuseSlip()
    {
        return $this->belongsTo(ExcuseSlip::class, 'excuse_slip_id');
    }
}