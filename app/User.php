<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Search param for api auth.
     *
     * @param string $username
     * @return string
     */
    public function findForPassport($username) {
        return $this->where('email', $username)->first();
    }

    public function group(){
        return $this->hasOne(Group::class,'id','group_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'user_id','id');
    }

    public function userCreateTasks(){
        return $this->hasMany(Task::class,'creator_id','id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'comment_id','id');

    }
}
