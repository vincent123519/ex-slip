<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name',
        'role_description',
    ];

    /**
     * Define a one-to-many relationship with the Users table.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')
            ->withPivot('role_name');
    }
    // Add any other relationships or methods relevant to your project
}