<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * Get the notes for the users.
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Notes');
    }

    public function shows(){
        return $this->hasMany('App\Models\Productions');
    }

    protected $dates = [
        'deleted_at'
    ];
}
