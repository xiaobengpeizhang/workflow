<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->string('requestNo',50)->unique();   //前缀LV+时间戳
            $table->integer('user_code',50);  //员工编号
            $table->foreign('user_code')->references('user_code')->on('userInfos');
            $table->string('type');        //请假类型：病假，婚假，产假。。。。
            $table->string('reason');
            $table->datetime('startTime');
            $table->datetime('endTime');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
