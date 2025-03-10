<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    use HasFactory;

   
    // Notifiable, 
    // HasApiTokens, 
    // HasRoles;

protected $fillable = [
    'name', 'email', 'password', 'phone_number', 'super_admin', 'status',
];
}
