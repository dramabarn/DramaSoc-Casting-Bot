<?php

namespace App\Http\Controllers;

use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Shows;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ChoicesController extends Controller
{
    /**
     * @param int $id - Show id
     * @return array
     */
    public static function showChoices($id){
        $productionRoles = ActorRoles::where('show', $id)->pluck('id');
        $choices = Choices::whereIn('role_name', $productionRoles)->get();
        return self::convertChoices($choices);
    }

    /**
     * Convert Choices to vue readable arrays
     * @param Collection $choices - array from Choices model
     * @param bool $include_showData - get show information too?
     * @return array
     */
    public static function convertChoices(Collection $choices, bool $include_showData = false): array
    {
        if ($include_showData){
            $shows = Shows::all();
        }
        $data = [];
        foreach ($choices as $choice) {
            $item = [];
            $item['role'] = ActorRoles::where('id', $choice['role_name'])->first()->role_name;

            if ($include_showData){
                $showId = ActorRoles::where('id',$choice['role_name'])->first()->show;
                $item['show'] = $shows->where('id',$showId)->first()->name;
                $item['week'] = $shows->where('id',$showId)->first()->week;
                $item['type'] = $shows->where('id',$showId)->first()->type;
                $item['castId'] = $choice['id'];
            }

            $actor = Actors::where('id', $choice['1st_choice'])->first();
            $item['first'] = !empty($actor->name) ? $actor->name : '';

            $actor = Actors::where('id', $choice['2nd_choice'])->first();
            $item['second'] = !empty($actor->name) ? $actor->name : '';

            $actor = Actors::where('id', $choice['3rd_choice'])->first();
            $item['third'] = !empty($actor->name) ? $actor->name : '';
            array_push($data, $item);
        }
        return $data;
    }
}
