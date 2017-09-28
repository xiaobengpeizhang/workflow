<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\History;

class Leave extends Model
{
    protected $table = 'leaves';

    protected $fillable = [
        'requestNo', 'user_code', 'type','reason','startTime','endTime'
    ];

    //获取这条请假申请上所有关联的历史消息
    public function getHistory(){
//        return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
        return $this->hasMany('App\History' ,'requestNo','requestNo');
    }
}
