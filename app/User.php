<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    //defining one to one relationshiip with post table
    public function post(){
        return $this->hasOne('App\Post');//by default it is going to search for column user_id
        //if we have specied in any other way we have to define it like
        //return $this->hasOne('App\Post','the columm name');
    }



    //defining one to many relationship with post table
    public function posts(){
        return $this->hasMany('App\Post');
}




public function roles(){
//        return $this->belongsToMany('App\Role');
        return $this->belongsToMany('App\Role')->withPivot('user_id','role_id','created_at');
        //if we have defined the pivot table name in any other way than the convention (the alphabetical convention)we have to define the foreign key of that table
        //like
//    return $this->belongsToMany('App\Role','user_role','user_id','role_id');
//    return $this->belongsToMany(related:'App\Role',table:'user_role',foreignPivotKey:'user_id',relatedPivotKey:'role_id');

    //second one is written by me to understand the first one

}
}
