<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{


    //to return the user to specific role

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
