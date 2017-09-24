<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('requestType',50);   //属于哪种流程？请假or加班
            $table->string('pre_node',3);
            $table->foreign('pre_node')->references('nodeCode')->on('nodes');
            $table->string('next_node',3);
            $table->foreign('next_node')->references('nodeCode')->on('nodes');
            $table->string('action',50);  //审批动作：提交or同意or拒绝
            $table->string('description')->nullable();
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
        Schema::dropIfExists('routes');
    }
}
