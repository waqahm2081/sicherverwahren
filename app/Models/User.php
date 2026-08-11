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
        'approved_at',
        'access_ends_at',
        'selected_package',
        'selected_option_type',
        'preferred_language',
        'payment_token',
        'payment_completed',
        'shipped_at',
        'shipping_date',
        'tracking_number',
        'appointment_date',
        'appointment_location',
        'contact_person',
        'quoted_amount_chf',
        'applied_coupon_code',
        'reminder_10d_sent_at',
        'expired_email_sent_at',
        'upsell_secure5_sent_at',
        'upsell_pro7_sent_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'      => 'datetime',
        'password'               => 'hashed',
        'is_approved'            => 'boolean',
        'payment_completed'      => 'boolean',
        'approved_at'            => 'datetime',
        'access_ends_at'         => 'datetime',
        'shipped_at'             => 'datetime',
        'shipping_date'          => 'date',
        'reminder_10d_sent_at'   => 'datetime',
        'expired_email_sent_at'  => 'datetime',
        'upsell_secure5_sent_at' => 'datetime',
        'upsell_pro7_sent_at'    => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function activateCourseAccess(): void
    {
        $this->update([
            'is_approved'    => true,
            'approved_at'    => now(),
            'access_ends_at' => now()->addDays(60),
        ]);
    }

    public function hasActiveCourseAccess(): bool
    {
        if (! $this->access_ends_at) {
            return false;
        }

        return $this->access_ends_at->isFuture();
    }

    public function daysLeftOnAccess(): int
    {
        if (! $this->access_ends_at) {
            return 0;
        }

        return max(0, (int) now()->diffInDays($this->access_ends_at, false));
    }
}
