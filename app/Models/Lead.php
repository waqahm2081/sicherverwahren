<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'source', 'status', 'notes', 'followup_sent_at'];

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CUSTOMER = 'customer';

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW       => 'Neu',
            self::STATUS_CONTACTED => 'Kontaktiert',
            self::STATUS_CUSTOMER  => 'Kunde',
        ];
    }

    protected $casts = [
        'followup_sent_at' => 'datetime',
    ];
}
