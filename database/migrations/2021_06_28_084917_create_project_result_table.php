<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_result', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('project');
            $table->string('name', 50);
            $table->string('introduction', 1024);
            $table->string('type', 512);
            $table->string('function', 1024)->nullable();
            $table->string('teacher', 10);
            $table->string('team', 50);
            $table->string('movie_file_name', 512)->nullable();
            $table->string('pic_file_name1', 512);
            $table->string('pic_file_name2', 512)->nullable();
            $table->string('pic_file_name3', 512)->nullable();
            $table->string('pic_file_name4', 512)->nullable();
            $table->string('pic_file_name5', 512)->nullable();
            $table->string('executable_file_name', 512);
            $table->string('pm_material', 512)->nullable();
            $table->string('gd_material', 512)->nullable();
            $table->string('ga_material', 512)->nullable();
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
        Schema::dropIfExists('project_result');
    }
}
