<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Overtime;
use App\User;
use App\History;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApproveController extends Controller
{
    //登录验证
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showApproveList()
    {
        return view('approve.approving');
    }

    //根据条件取回待审批列表
    public function getApproveList()
    {

        $userInfo = User::find(Auth::id())->userInfo;

        switch ($userInfo->position) {
            case '组长':
                $param = array(
                    'node' => '20',
                    'group_id' => $userInfo->group_id,
                    'depart_id' => $userInfo->depart_id
                );
                $sqlstr = 'SELECT A.requestNo,C.realName, B.requestType,A.type,B.description,A.created_at,B.pre_node,B.next_node FROM (SELECT * FROM leaves union SELECT * FROM overtimes) AS A LEFT JOIN routes AS B ON A.route_id = B.id LEFT JOIN userinfos AS C ON A.user_code = C.user_code WHERE B.next_node = :node AND C.depart_id = :depart_id AND C.group_id = :group_id';
                $data = DB::select($sqlstr, $param);
                break;
            case '部长':
                $param = array(
                    'node' => '40',
//                    'group_id' =>$userInfo->group_id,
                    'depart_id' => $userInfo->depart_id
                );
                $sqlstr = 'SELECT A.requestNo,C.realName, B.requestType,A.type,B.description,A.created_at,B.pre_node,B.next_node FROM (SELECT * FROM leaves union SELECT * FROM overtimes) AS A LEFT JOIN routes AS B ON A.route_id = B.id LEFT JOIN userinfos AS C ON A.user_code = C.user_code WHERE B.next_node = :node AND C.depart_id = :depart_id';
                $data = DB::select($sqlstr, $param);
                break;
            default:
                $data = [];
                break;
        }

        $response = array(
            'code' => 0,
            'msg' => 'success',
            'count' => count($data),
            'data' => $data
        );
        return $response;


    }

    public function agrree(Request $request)
    {
        $this->validate($request, [
            'requestNo' => 'required',
            'message' => 'nullable|max:225'
        ]);
        $userInfo = User::find(Auth::id())->userInfo;

        switch (substr($request->requestNo, 0, 2)) {
            case 'LV':
                $oldApplication = DB::table('leaves')->where('requestNo', '=', $request->requestNo)->first();
                $date = floor((strtotime($oldApplication->endTime) - strtotime($oldApplication->startTime)) / 86400);
                if($userInfo->positon == '组长'){
                    if ($date >= 2 ) {
                        DB::table('leaves')->where('requestNo', '=', $request->requestNo)->update(['route_id' => 2]);
                    } else {
                        DB::table('leaves')->where('requestNo', '=', $request->requestNo)->update(['route_id' => 5]);
                    }
                }else if($userInfo->position == '部长'){
                    DB::table('leaves')->where('requestNo', '=', $request->requestNo)->update(['route_id' => 3]);
                }

                $application = Leave::where('requestNo', '=', $request->requestNo)->first();
                break;
            case 'OT':
                if($userInfo->postion == '组长'){
                    DB::table('overtimes')->where('requestNo', '=', $request->requestNo)->update(['route_id' => 8]);
                }elseif($userInfo->position == '部长'){
                    DB::table('overtimes')->where('requestNo', '=', $request->requestNo)->update(['route_id' => 10]);
                }
                $application = DB::table('overtimes')->where('requestNo', '=', $request->requestNo)->first();
                break;
            default:
                break;
        }


        //新增一条历史
        $history = new History;
        $history->requestNo = $request->requestNo;
        $history->route_id = $application->route_id;
        $history->userCode = User::find(Auth::id())->userInfo->user_code;
        $history->message = $request->message;
        $history->save();

        return 'updateSuccess';

    }

    public function disagree(Request $request){
        $this->validate($request, [
            'requestNo' => 'required',
            'message' => 'nullable|max:225'
        ]);
        $userInfo = User::find(Auth::id())->userInfo;

        switch(substr($request->requestNo,0,2)){
            case 'LV':
                if($userInfo->position == '组长'){
                    DB::table('leaves')->where('requestNo','=',$request->requestNo)->update(['route_id'=>4]);
                }elseif($userInfo->position == '部长'){
                    DB::table('leaves')->where('requestNo','=',$request->requestNo)->update(['route_id'=>6]);
                }
                $application = Leave::where('requestNo', '=', $request->requestNo)->first();
                break;
            case 'OV':
                if($userInfo->position == '组长'){
                    DB::table('overtimes')->where('requestNo','=',$request->requestNo)->update(['route_id'=>9]);
                }elseif($userInfo->position == '部长'){
                    DB::table('overtimes')->where('requestNo','=',$request->requestNo)->update(['route_id'=>11]);
                }
                $application = Overtime::where('requestNo','=',$request->requestNo)->first();
                break;
            default:
                break;
        }

        //新增一条历史
        $history = new History;
        $history->requestNo = $request->requestNo;
        $history->route_id = $application->route_id;
        $history->userCode = $userInfo->user_code;
        $history->message = $request->message;
        $history->save();

        return 'updateSuccess';
    }
}
