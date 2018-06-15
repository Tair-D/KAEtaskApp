<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('status_name')->comment('название статуса');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->text('project_name')->comment('название проекта');
            $table->integer('status_id')->unsigned()->comment('статус');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();

        });

        Schema::create('versions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('version_name')->comment('название название версии(по умолчании)');
            $table->integer('project_id')->unsigned()->comment('ID проекта');
            $table->foreign('project_id')->references('id')->on('projects')->ondelete('cascade');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');

            $table->timestamps();
        });


        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->comment('Заголовок');
            $table->text('description')->comment('Описание');

            $table->date('deadline')->default('08.06.2019')->comment('дата завершении');//---
            $table->integer('project_id')->unsigned()->default(1)->comment('ID проекта');//---
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('user_id')->unsigned()->default(1)->comment('ID пользователя');//----
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('creator_id')->unsigned()->default(1)->comment('ID создателя');//----
            $table->foreign('creator_id')->references('id')->on('users');

            $table->integer('status_id')->unsigned()->default(1);
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();

        });

        Schema::create('comments',function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('ID пользователя');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('task_id')->unsigned()->comment('ID задачи');
            $table->foreign('task_id')->references('id')->on('tasks');
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
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('versions');
        Schema::dropIfExists('comments');


    }
}
