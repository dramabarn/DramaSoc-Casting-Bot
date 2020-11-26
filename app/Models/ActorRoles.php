<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActorRoles extends Model
{
    use HasFactory;
    protected $table = 'actor_roles';

    public function shows(){
        return $this->hasMany('App\Models\Productions');
    }

//    public function actors(){
//        return $this->hasMany('App\Models\Productions');
//    }
}
