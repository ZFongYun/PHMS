<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMaterialToProjectResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_result', function (Blueprint $table) {
            $table->dropColumn(['gd_material','ga_material']);
            $table->renameColumn('pm_material', 'material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_result', function (Blueprint $table) {
            $table->renameColumn('material', 'pm_material');
        });
    }
}
