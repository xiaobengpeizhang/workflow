<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->string('requestNo',50)->unique();   //前缀OT+时间戳
            $table->integer('user_code',50);  //员工编号
            $table->string('type');        //加班类型：平日，周末。。。。
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
        Schema::dropIfExists('overtimes');
    }
}
