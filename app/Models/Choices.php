<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choices extends Model
{
    use HasFactory;
    public function production(){
        return $this->hasOneThrough('App\Models\ActorRoles','App\Models\Productions','show_id','role_id');
    }
}
