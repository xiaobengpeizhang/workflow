<?php

namespace App\Http\Controllers;

use App\Department;
use App\Group;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getDepartList(){
        $departments = Department::all();
        return $departments;  //自动返回json数据
    }

    public function getGroupList($depart_id){
        $groups = Group::where('depart_id','=',$depart_id)->get();
        return $groups;
    }
}
