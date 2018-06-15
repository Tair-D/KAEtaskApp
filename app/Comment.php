<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   protected $table=('comments');

   public function user(){
       return $this->hasOne(User::class,'id','user_id');
   }

   public function task(){
       return $this->hasOne(Task::class,'id','task_id');
   }
}
