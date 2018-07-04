<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRowVersionIdToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks',function($table){
            $table->integer('version_id')->unsigned()->default(1)->after('project_id')->comment('ID версии');//---
            $table->foreign('version_id')->references('id')->on('versions');
        });//?????????????
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
