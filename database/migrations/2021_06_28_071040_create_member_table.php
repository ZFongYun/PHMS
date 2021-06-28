<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->char('student_ID', 15)->unique();
            $table->string('name', 10);
            $table->char('password', 40);
            $table->char('email', 50)->nullable();
            $table->char('join_year', 3);
            $table->char('title', 1);
            $table->string('skill', 1024)->nullable();
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
        Schema::dropIfExists('member');
    }
}
