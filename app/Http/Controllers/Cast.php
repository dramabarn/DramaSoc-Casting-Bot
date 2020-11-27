<?php

namespace App\Http\Controllers;

use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Productions;
use Illuminate\Http\Request;

class Cast extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(){
        $you = auth()->user();
        return view("user.home",[
            'username' => $you->name,
        ]);
    }

    public function enter(){
        $you = auth()->user();
        $production = Productions::where('user_id',$you->id)->first()->show_id;
        $productionRoles = ActorRoles::where('show',$production)->get();
        $actors = Actors::all();

        return view("user.enter",[
            'productionRoles' =>$productionRoles,
            'actors'=>$actors,
        ]);
    }

    public function choices(){
        $you = auth()->user();
        $data = [];
        //get user's production, then the roles relevant to that production, then the choices relevant to those roles
        $production = Productions::where('user_id',$you->id)->first()->show_id;
        $productionRoles = ActorRoles::where('show',$production)->pluck('id');
        $choices = Choices::whereIn('role_name', $productionRoles)->get();
        //change array formatting so keys are usable in vue (numbers are invalid)
        foreach ($choices as $choice){
            $item;
            //this shit needs validation
            $item['role'] = ActorRoles::where('id',$choice['role_name'])->first()->role_name;
            $item['first'] = Actors::where('id',$choice['1st_choice'])->first()->name;
            $item['second'] = Actors::where('id',$choice['2nd_choice'])->first()->name;
            $item['third'] = Actors::where('id',$choice['3rd_choice'])->first()->name;
            array_push($data,$item);
        }

        return view("user.choices",[
            'productionChoices' => $data,
        ]);
    }
}
