<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const APPOINTED          = 1; // назначен
    const PROCESS= 2; // в работе
    const FULFILLED=3;// выполнен
    const FEEDBACK=4;//обратная связь
    const COMPLETED=5;//завершен

    public function statusTask(){
        return $this->hasMany(Task::class,'status_id','id');
    }

    public function statusProject(){
        return $this->hasMany(Task::class,'status_id','id');
    }

    public function statusVersion(){
        return $this->hasMany(Task::class,'status_id','id');
    }
}
