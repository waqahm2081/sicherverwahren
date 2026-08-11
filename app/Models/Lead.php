<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'source', 'followup_sent_at'];

    protected $casts = [
        'followup_sent_at' => 'datetime',
    ];
}
