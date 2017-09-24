<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';

    protected $fillable = [
        'requestNo', 'user_code', 'type','reason','startTime','endTime'
    ];
}
