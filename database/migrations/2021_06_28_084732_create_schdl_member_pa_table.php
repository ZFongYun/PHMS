<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchdlMemberPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schdl_member_pa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_schdl_id');
            $table->foreign('project_schdl_id')->references('id')->on('project_schdl');
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('member');
            $table->char('score', 1);
            $table->string('explanation', 1024)->nullable();
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
        Schema::dropIfExists('schdl_member_pa');
    }
}
