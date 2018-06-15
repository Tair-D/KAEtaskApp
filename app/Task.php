<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";

    public function creatorUser(){
        return $this->hasOne(User::class,'id','creator_id');
    }
    public function executedUser(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function status(){
        return $this->hasOne(Status::class ,'id','status_id');
    }

    public function project(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function version(){
        return $this->hasOne(Version::class,'id','version_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'comment_id','id');
    }

}
