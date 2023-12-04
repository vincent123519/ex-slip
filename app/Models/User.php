<?php

// User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasRoles;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Define a many-to-one relationship with the UserRole model.
     */
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    /**
     * Define a one-to-one relationship with the HeadCounselor model.
     */
    public function headCounselor()
    {
        return $this->hasOne(HeadCounselor::class, 'user_id');
    }
    

    // ... (other relationships)

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

