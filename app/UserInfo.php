<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'userInfos';

    protected $fillable = [
        'user_code','user_id', 'realName', 'sex','position','group_id','depart_id'
    ];
}
