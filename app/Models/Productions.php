<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productions extends Model
{
    use HasFactory;
    protected $table = 'productions';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function choices(){
        return $this->hasManyThrough('App\Models\Choices','App\Models\ActorRoles','show_id','role_id');
    }


}
