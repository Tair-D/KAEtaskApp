<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table='versions';

    public function status(){
        return $this->hasOne(Status::class,'id','status_id');
    }

    public function project(){
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'version_id','id');
    }

}
