<?php

namespace App\Models;

use App\Models\Rental;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'address',
        'city',
        'zip_code',
    ];
   
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}

    
    

