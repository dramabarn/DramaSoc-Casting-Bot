<?php

namespace App\Http\Controllers;

use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use Illuminate\Http\Request;

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
        return view("admin.index");
    }

    public function add(){
        return view("admin.addPlay");
    }


    public function view(){

        return view("admin.viewProductions");
    }

    public function people(){

        $actors = Actors::all();

        return view("admin.people",[
            'people'=>$actors,
        ]);
    }

}
