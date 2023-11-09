<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'username',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Define a many-to-many relationship with the UserRole model.
     */
    public function roles()
    {
        return $this->belongsToMany(UserRole::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Define a one-to-one relationship with the HeadCounselor model.
     */
    public function headCounselor()
    {
        return $this->hasOne(HeadCounselor::class, 'user_id');
    }

    /**
     * Define a one-to-one relationship with the Teacher model.
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    /**
     * Define a one-to-one relationship with the Counselor model.
     */
    public function counselor()
    {
        return $this->hasOne(Counselor::class, 'user_id');
    }

    /**
     * Define a one-to-one relationship with the Dean model.
     */
    public function dean()
    {
        return $this->hasOne(Dean::class, 'user_id');
    }

    /**
     * Define a one-to-one relationship with the Student model.
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    /**
     * Define a one-to-many relationship with the ExcuseSlip model.
     */
    public function excuseSlips()
    {
        return $this->hasMany(ExcuseSlip::class, 'user_id');
    }

    /**
     * Define a one-to-many relationship with the Feedback model.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'sender_id');
    }
}