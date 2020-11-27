<?php

namespace App\Http\Controllers;

use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Productions;
use App\Models\Shows;
use Illuminate\Http\Request;
use Spatie\Permission\Commands\Show;

class AdminController extends Controller
{
    //
    public function index(){
        $you = auth()->user();
        return view("admin.index",[
            'username' => $you->name,
        ]);
    }

    public function meeting(){
        $productions = Shows::all();
        $casted = $this->getCastedRoles();
        $productionchoices = $this->getChoices();
        $freeCast = $this->getFreeToCast();

        return view("admin.castingMeeting",
            [
                'productions'=>$productions,
                'productionchoices'=>$productionchoices,
                'casted'=>$casted,
                'freeCast'=>$freeCast
            ]);
    }

    private function getCastedRoles(){
        $casts = Choices::all();
        $shows = Shows::all();
        $roles = ActorRoles::all();

        $productionRoles = $roles->pluck('id');
        $choices = $casts->where('casted', "true")->whereIn('role_name', $productionRoles);
        //change array formatting so keys are usable in vue (numbers are invalid)
        $data = [];
        foreach ($choices as $choice){
                $item;
                $showId = ActorRoles::where('id',$choice['role_name'])->first()->id;
                //this shit needs validation
                $item['show'] = $shows->where('id',$showId)->first()->name;
                $item['role'] = ActorRoles::where('id',$choice['role_name'])->first()->role_name;
                $item['name'] = Actors::where('id',$choice['1st_choice'])->first()->name;
                array_push($data,$item);
        }

        return $data;
    }

    private function getChoices(){
        $casts = Choices::all();
        $choices = $casts->where('casted', "false");
        $shows = Shows::all();

        //change array formatting so keys are usable in vue (numbers are invalid)
        $data = [];
        foreach ($choices as $choice){
            $item;
            $showId = ActorRoles::where('id',$choice['role_name'])->first()->show;
            //this shit needs validation
            $item['show'] = $shows->where('id',$showId)->first()->name;
            $item['role'] = ActorRoles::where('id',$choice['role_name'])->first()->role_name;
            $item['first'] = Actors::where('id',$choice['1st_choice'])->first()->name;
            $item['second'] = Actors::where('id',$choice['2nd_choice'])->first()->name;
            $item['third'] = Actors::where('id',$choice['3rd_choice'])->first()->name;
            array_push($data,$item);
        }

        return $data;

    }

    private function getFreeToCast(){
        $casts = Choices::all();
        $castings = $casts->where('casted', "false");
        //we maintain 3 arrays - single casts, adjacent casts and sharing casts
        $SINGLE_CASTS = array();

        //FIRSTLY, WE NEED TO CHECK FOR NON-CONFLICTS (only looking at 1st choices)
        $over_1 = true;
        foreach($castings as $casting){
            $SINGLE = true;
            foreach($castings as $others){
                if($casting['id'] != $others['id']){

                    if($casting['1st_choice'] == $others['1st_choice']){
                        $SINGLE = false;
                    }
                    if($casting['1st_choice'] == $others['2nd_choice']){
                        $SINGLE = false;
                    }
                    if($casting['1st_choice'] == $others['3rd_choice']){
                        $SINGLE = false;
                    }
                }
            }
            if($SINGLE){
                array_push($SINGLE_CASTS, $casting);
                $over_1 = true;
            }
        }

        return $SINGLE_CASTS;
    }


    public function add(){
        return view("admin.addPlay");
    }


    public function view(){
        $productions = Shows::all();

        return view("admin.viewProductions",
        [            'productions'=>$productions,
        ]);
    }

    public function people(){

        $actors = Actors::all();

        return view("admin.people",[
            'people'=>$actors,
        ]);
    }

}
