<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table='projects';

    public function status(){
        return $this->hasOne(Status::class,'id','status_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'project_id','id');
    }

    public function versions(){
        return $this->hasMany(Version::class,'version_id','id');
    }
}
