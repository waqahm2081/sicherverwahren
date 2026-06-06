<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_approved',
        'selected_package',
        'selected_option_type',
        'preferred_language',
        'payment_token',
        'payment_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'  => 'datetime',
        'password'           => 'hashed',
        'is_approved'        => 'boolean',
        'payment_completed'  => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}