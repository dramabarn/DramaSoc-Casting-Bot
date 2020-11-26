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
        $production = Choices::all();
        dd($production);

        $productionRoles = ActorRoles::where('show',$production)->get('id');
        $choices = Choices::where('role_name',$role)->get();

        dd($choices);
        $actors = Actors::all();

        return view("user.choices",[
            'choices'
        ]);
    }
}
