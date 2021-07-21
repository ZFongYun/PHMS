<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyPaStartTimeAndPaEndTimeToProjectSchdlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_schdl', function (Blueprint $table) {
            DB::statement('ALTER TABLE project_schdl MODIFY COLUMN pa_start_time time');
            DB::statement('ALTER TABLE project_schdl MODIFY COLUMN pa_end_time time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_schdl', function (Blueprint $table) {
            DB::statement('ALTER TABLE project_schdl MODIFY COLUMN pa_start_time timestamp ');
            DB::statement('ALTER TABLE project_schdl MODIFY COLUMN pa_end_time timestamp ');
        });
    }
}
