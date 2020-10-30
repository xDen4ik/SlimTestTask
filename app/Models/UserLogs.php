<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    public $timestamps = false;
    protected $table = 'user_logs';

    protected $fillable =
    [
        'user_id',
        'session_id',
        'created_at',
    ];
}
