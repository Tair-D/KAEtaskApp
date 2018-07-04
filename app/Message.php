<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table='messages';

    protected function sender(){
        return $this->hasOne(User::class,'id','sender_id');
    }

    protected function receiver(){
        return $this->hasOne(User::class,'id','receiver_id');
    }
}
