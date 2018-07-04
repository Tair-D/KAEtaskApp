<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullCommentText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments',function (Blueprint $table){
            $table->increments('id');
            $table->text('comment_text')->comment('Комментарии')->nullable();
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
        //
    }
}
