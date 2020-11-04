<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    public $timestamps = false;
    protected $table = 'sessions';

    protected $fillable =
    [
        'session_id',
        'user_id',
        'user_ip',
        'device_type',
        'browser',
        'action',
    ];
}
