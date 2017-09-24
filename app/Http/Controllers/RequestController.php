<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Leave;
use App\UserInfo;
use App\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    //新建请假申请
    public function showLeaveForm(){
        return view('request.askForLeave');
    }

    public function createLeave(Request $form){
        $this->validate($form,[
            'type'=>'required',
            'reason'=>'required|min:2|max:225',
            'start'=>'required',
            'end'=>'required',
            'message'=>'nullable|max:225'
        ]);

        $uesrInfo = UserInfo::where('user_id','=',Auth::id())->first();

        //新增一条申请
        $leave = new Leave;
        $leave->requestNo = 'LV'.strval(time());
        $leave->user_code = $uesrInfo->user_code;
        $leave->type = $form->type;
        $leave->reason = $form->reason;
        $leave->startTime = $form->start;
        $leave->endTime = $form->end;
        $leave->save();

        //计算时间差
//        $date=floor((strtotime($form->end)-strtotime($form->start))/86400);

        //新增一条历史
        $history = new History;
        $history->requestNo = $leave->requestNo;
        $history->route_id = 1;
        $history->userCode = $uesrInfo->user_code;
        $history->message = $form->message;
        $history->save();

        return redirect()->route('admin',['result' => 'createLeaveSuccessed']);
    }

    //搜索所有请假申请
    public function showSearchForm(){
        return view('request.searchMyRequest');
    }
    public function searchRequest(Request $form){
        $this->validate($form,[
           'type'=>'required',
            'status'=>'required',
            'start'=>'required|date',
            'end'=>'required|date'
        ]);
        //获取当前登录用户所有的申请信息
        $uesrInfo = UserInfo::where('user_id','=',Auth::id())->first();
        $leaves = DB::table('leaves')->where('user_code','=',$uesrInfo->user_code)->get();

        //TODO:根据条件进行筛选，需要关联其他的表格模型
        return view('request.getRequests',$leaves);
    }
}
