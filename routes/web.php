<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//欢迎页面
Route::get('/home', 'HomeController@index')->name('home');

//主系统页面
Route::get('admin','HomeController@admin')->name('admin');

Route::group(['prefix' => 'user'],function(){
    //注册用户信息
    Route::post('userInfo','UserController@setUserInfo')->name('setUserInfo');
});

//一些获取数据的接口
Route::group(['prefix'=>'api'],function(){
    //获取部门列表
    Route::get('getDepartList','ApiController@getDepartList')->name('getDepartList');
    //根据部门列表获取小组列表
    Route::get('getGroupList/{depart_id}','ApiController@getGroupList')->name('getGroupList');
});

//我要申请
Route::group(['prefix'=>'request'],function(){
    //申请请假
    Route::get('askForLeave','RequestController@showLeaveForm')->name('askForLeave');
    Route::post('createLeaveRequest','RequestController@createLeave')->name('createLeave');
    //加班申请
    Route::get('askForOvertime','RequestController@showOvertimeForm')->name('askForOvertime');
    Route::post('createOvertimeRequest','RequestController@createOvertime')->name('createOvertime');

    //我的申请
    Route::get('myRequest','RequestController@showSearchForm')->name('myRequest');
    //查询申请列表
    Route::get('searchRequest','RequestController@searchRequest')->name('searchRequest');

    //查看指定申请的详情
    Route::get('leaveDetail/{requestNo?}','RequestController@getLeaveDetail')->name('getLeaveDetail');
});

//我的审批
Route::group(['prefix'=>'approve'],function(){
   //等待审批列表
    Route::get('waitingForApprove','ApproveController@showApproveList')->name('waitingApprove');
    //根据条件查找审批列表
    Route::get('getApproveList','ApproveController@getApproveList')->name('getApproveList');

    //组长审批
    Route::post('agree','ApproveController@agrree')->name('agree');
    Route::post('disagree','ApproveController@disagree')->name('disagree');
});