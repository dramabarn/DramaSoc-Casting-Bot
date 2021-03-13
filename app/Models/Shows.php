<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shows extends Model
{
    use HasFactory;
    protected $table = 'shows';

    /**
     * @param int|false $showid
     * @return Shows|Shows[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public static function getAdditionalData($showid=false){
        $productions = [];
        if ($showid == false){
            $productions = Shows::all();

        } else {
            array_push($productions, Shows::where('id', intval($showid))->first());
        }
        foreach ($productions as $show){
            $prod = Productions::where('show_id', $show->id)->first();
            $producer = User::where('id', $prod->user_id)->first();
            $roles = ActorRoles::where('show', $show->id)->count();
            $show->prod = $producer->name;
            $show->email = $producer->email;
            $show->roles = $roles;
        }

        return $productions;
    }

}
