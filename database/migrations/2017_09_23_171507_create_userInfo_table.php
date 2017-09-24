<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userInfos', function (Blueprint $table) {
            $table->increments('user_code');  //员工编号
            $table->integer('user_id')->unsigned();  //用户id
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('realName',50); //真实姓名
            $table->string('sex',5);
            $table->string('position',50);
            $table->integer('group_id')->unsigned();
            $table->integer('depart_id')->unsigned(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userInfos');
    }
}
