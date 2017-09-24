<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserInfo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $userInfo = UserInfo::where('user_id','=',$user_id)->get();
        if($userInfo->isEmpty() == false){
            return redirect()->route('admin');
        }
        return view('home');
    }

    //正式进入系统控制台页面
    public function admin($result = null){
        $user_id = Auth::id();
        $userInfo = UserInfo::where('user_id','=',$user_id)->get();
        if($userInfo->isEmpty()){
            return redirect()->route('home');
        }
        return view('index')->with('result',$result);
    }
}
