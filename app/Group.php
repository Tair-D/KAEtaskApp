<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table='group';

    public function users(){
        return $this->hasMany(User::class,'group_id','id');
    }
}
