<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $table = 'overtimes';

    protected $fillable = [
        'requestNo', 'user_code', 'type','reason','startTime','endTime'
    ];

    //获取这条请假申请上所有关联的历史消息
    public function getHistory(){
//        return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
        return $this->hasMany('App\History' ,'requestNo','requestNo');
    }
//    //获取最新的历史消息
//    public function getCurrentHistory(){
//        return $this->getHistory->latest()->first();
//    }

    public function route(){
        return $this->hasOne('App\Route','route_id','id');
    }
}
