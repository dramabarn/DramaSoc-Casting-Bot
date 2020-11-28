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

    private function getChoiceData(){
        $you = auth()->user();
        //get user's production, then the roles relevant to that production, then the choices relevant to those roles
        $production = Productions::where('user_id',$you->id)->first()->show_id;
        $productionRoles = ActorRoles::where('show',$production)->pluck('id');
        $choices = Choices::whereIn('role_name', $productionRoles)->get();
        //change array formatting so keys are usable in vue (numbers are invalid)
        $data = [];
        foreach ($choices as $choice){
            $item;
        
            $item['role'] = ActorRoles::where('id',$choice['role_name'])->first()->role_name;

            $actor = Actors::where('id',$choice['1st_choice'])->first();
            $item['first'] = !empty($actor->name) ? $actor->name:'';

            $actor = Actors::where('id',$choice['2nd_choice'])->first();
            $item['second'] = !empty($actor->name) ? $actor->name:'';

            $actor = Actors::where('id',$choice['3rd_choice'])->first();
            $item['third'] = !empty($actor->name) ? $actor->name:'';
            array_push($data,$item);
        }
        return $data;
    }

    public function enter(){
        $you = auth()->user();
        $production = Productions::where('user_id',$you->id)->first()->show_id;
        $productionRolesNames = ActorRoles::where('show',$production)->get();
        $actors = Actors::all();
        $data = $this->getChoiceData();

        return view("user.enter",[
            'productionRoles' =>$productionRolesNames,
            'actors'=>$actors,
            'productionChoices' => $data,
        ]);
    }

    public function choices(){

        $data = $this->getChoiceData();

        return view("user.choices",[
            'productionChoices' => $data,
        ]);
    }

    public function addRole(){
        return view("user.addRole");
    }

    /**
     * Store a newly created role member in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRole(Request $request)
    {
        $you = auth()->user();
        $production = Productions::where('user_id',$you->id)->first()->show_id;

        $request->validate([
            'name' => 'required',
        ]);

        $role = new ActorRoles();

        $role->name = $request->name;
        $role->show = $production;

        $role->save();
        return response()->json([
            'message' => 'Successfully created Role!',
            'id' => $role->id
        ], 201);
    }
}
