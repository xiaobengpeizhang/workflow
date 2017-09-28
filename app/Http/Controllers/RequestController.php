<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
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

        return "createLeaveSuccessed";
    }

    //搜索所有请假申请
    public function showSearchForm(){
        return view('request.searchMyRequest');
    }

    /**
     * @param Request $form
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchRequest(Request $form){
        $this->validate($form,[
           'type'=>'required',
            'status'=>'required',
            'start'=>'required|date',
            'end'=>'required|date'
        ]);
        //获取当前登录用户所有的申请信息
        $userInfo = UserInfo::where('user_id','=',Auth::id())->first();
//        $leaves = DB::table('leaves')->where('user_code','=',$uesrInfo->user_code)->get()->toArray();
        $status = "";
        switch($form->status){
            case '等待中':
                $status = "AND B.route_id IN (1,2)";
                break;
            case '已通过':
                $status = "AND B.route_id IN (3,5)";
                break;
            case '被拒绝':
                $status = "AND B.route_id IN (4,6)";
                break;
            default:
                break;
        }
        $param = array(
            'user_code'=>$userInfo->user_code,
            'request_type'=>$form->type,
            'start'=>$form->start." ".date("H:i:s"),
            'end'=>$form->end." ".date("H:i:s"),
//            'status'=>$status
        );

        $sqlstr = 'SELECT A.requestNo, A.user_code,A.type,A.created_at,C.requestType,B.route_id,C.action,C.description FROM leaves AS A JOIN history AS B on A.requestNo = B.requestNo JOIN routes AS C ON B.route_id = C.id WHERE A.user_code = :user_code AND C.requestType = :request_type AND (A.created_at BETWEEN :start AND :end) '.$status;
        $leaves = DB::select($sqlstr,$param);
//        return view('request.getRequests',$leaves);

        $response = array(
            'code'=> 0,
            'msg'=>'success',
            'count'=>count($leaves),
            'data'=>$leaves
        );
        return $response;
    }

    //查看详情
    public function getLeaveDetail($requestNo = null){
        if($requestNo != null){
            //取回单条数据务必用first()或者find(),get()默认取回一个集合
            $leave = Leave::where('requestNo','=',$requestNo)->firstOrFail();
//            return compact($leave);
            return view('request.getDetail',compact('leave'));
//            return $leave->getHistory;
        }

    }

}
