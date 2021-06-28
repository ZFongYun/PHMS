<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSchdlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_schdl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('project');
            $table->string('name', 50);
            $table->date('schdl_start_date'); //進度開始與結束日期
            $table->date('schdl_end_date');
            $table->string('file_name', 512);
            $table->date('pa_start_date'); //考核開始日期與時間
            $table->timestamp('pa_start_time',0)->nullable();
            $table->date('pa_end_date'); //考核結束日期與時間
            $table->timestamp('pa_end_time',0)->nullable();
            $table->string('remark', 1024)->nullable();
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
        Schema::dropIfExists('project_schdl');
    }
}
