<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatables;

class Admin extends Authenticatables
{
    use HasFactory;
    use Notifiable;
    protected $gaurd = 'admin';
    protected $fillable = [
    	'name', 'type', 'mobile', 'email', 'password', 'image', 'status', 'created_at', 'updated_at', 
    ];
    protected $hidden = [
    	'password', 'remember_token',
    ];
}
