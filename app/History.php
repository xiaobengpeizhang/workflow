<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'requestNo', 'route_id', 'userCode','message'
    ];

    public function route(){
        return $this->belongsTo('App\Route','route_id','id');
    }

    public function user(){
        return $this->belongsTo('App\UserInfo','userCode','user_code');
    }
}
