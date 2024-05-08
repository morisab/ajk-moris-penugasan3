<?php

namespace App\Core\Domain\Models\Auth;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'kabupaten_id',
        'name',
        'email',
        'no_telp',
        'age',
        'image_url',
    ];

    protected $hidden = [
        'password',
    ];
}
