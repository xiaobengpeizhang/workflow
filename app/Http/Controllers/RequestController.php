<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    //新建请假申请
    public function showLeaveForm(){
        return view('request.askForLeave');
    }
}
