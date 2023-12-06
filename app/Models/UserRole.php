<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class UserRole extends Model

{
    use HasRoles; // Include the HasRoles trait

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name',
        'role_description',
    ];

    /**
     * Define a one-to-many relationship with the Users table.
     */
   
     
     public function user()
     {
         return $this->hasOne(User::class, 'role_id');
     }
     

    // Add any other relationships or methods relevant to your project
}