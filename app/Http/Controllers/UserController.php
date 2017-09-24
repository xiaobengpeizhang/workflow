<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInfo;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //只有登录以后才能看见
    public function __construct()
    {
        $this->middleware('auth');
    }

    //注册用户信息
    public function setUserInfo(Request $form){
        $this->validate($form,[
            'realName' => 'required|max:50',
            'sex' => 'required',
            'depart' =>'required',
            'group'=>'required',
            'position' => 'bail|nullable|max:50'
        ]);

        $userInfo = new UserInfo;
        $userInfo->user_id = Auth::id();
        $userInfo->realName = $form->realName;
        $userInfo->sex = $form->sex;
        $userInfo->position = $form->position;
        $userInfo->depart_id = $form->depart;
        $userInfo->group_id = $form->group;

        $userInfo->save();

        return redirect()->route('admin');
    }
}
