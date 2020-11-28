<?php

namespace App\Http\Controllers;

use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Shows;
use App\Models\Productions;
use Illuminate\Http\Request;

class Cast extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $you = auth()->user();
        $showInfo =[];
        $production = Productions::where('user_id',$you->id)->first();
        if (!empty($production)){
            $show = Shows::where('id', $production->show_id)->first();
            $roles = ActorRoles::where('show', $production->show_id)->count();
            $showInfo['hasShow'] = true;
            $showInfo['name'] = $show->name;
            $showInfo['type'] = $show->type;
            $showInfo['week'] = $show->week;
            $showInfo['roles'] = $roles;

            $choices = $this->getChoiceData();
        } else {
            $showInfo['hasShow'] = false;
            $choices = "";
        }
        return view("user.home",[
            'username' => $you->name,
            'productionChoices' => $choices,
            'showinfo' => $showInfo,
        ]);
    }

    private function getChoiceData()
    {
        $you = auth()->user();
        //get user's production, then the roles relevant to that production, then the choices relevant to those roles
        $production = Productions::where('user_id', $you->id)->first()->show_id;
        $productionRoles = ActorRoles::where('show', $production)->pluck('id');
        $choices = Choices::whereIn('role_name', $productionRoles)->get();
        //change array formatting so keys are usable in vue (numbers are invalid)
        $data = [];
        foreach ($choices as $choice) {
            $item;

            $item['role'] = ActorRoles::where('id', $choice['role_name'])->first()->role_name;

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

    public function enter()
    {
        $you = auth()->user();
        $production = Productions::where('user_id', $you->id)->first()->show_id;
        $productionRolesNames = ActorRoles::where('show', $production)->get();
        $actors = Actors::all();
        $data = $this->getChoiceData();

        return view("user.enter", [
            'productionRoles' => $productionRolesNames,
            'actors' => $actors,
            'productionChoices' => $data,
        ]);
    }

    public function storeChoice(Request $request)
    {
        $actors = Actors::all();

        $request->validate([
            'username' => 'required',
            'role_id'=>'required',
            'choice' => 'required'
        ]);

        $choices = Choices::all();
        $choice = $choices->where('role_name', $request->role_id)->first();

        $requestChoice = $request->choice;
        $requestEmail = $request->username;

        $emailExists = $actors->where('email', $requestEmail)->first();

        if($choice){
            if($emailExists != null){
                $actor_id = $actors->where('email', $requestEmail)->pluck('id');
                $choice->$requestChoice = $actor_id[0];
                $choice->save();
            }
            else{

                $actor = new Actors;
                $actor->name = $request->name;
                $actor->email= $request->username;
                $actor->phone = $request->phone;

                $actor->save();


                $actor_id = $actor->id;
                $choice->$requestChoice = $actor_id;
                $choice->save();

            }
        }
        else{
            if($emailExists != null){
                $actor_id = $actors->where('email', $request->username)->pluck('id');

                $choice = new Choices();
                $choice->role_name = $request->role_id;
                $choice->$requestChoice = $actor_id[0];
                $choice->casted = False;

                $choice->save();
            }
            else{

                $actor = new Actors;
                $actor->name = $request->name;
                $actor->email= $request->username;
                $actor->phone = $request->phone;

                $actor->save();

                $actor_id = $actor->id;

                $choice = new Choices();
                $choice->role_name = $request->role_id;
                $choice->$requestChoice = $actor_id;
                $choice->casted = False;

                $choice->save();
            }
        }


        return response()->json([
            'message' => 'Successfully stored/updated choice!',
            'id' => $choice->id
        ], 201);

    }

    public function choices()
    {

        $data = $this->getChoiceData();

        return view("user.choices", [
            'productionChoices' => $data,
        ]);
    }

    public function addRole()
    {
        $you = auth()->user();
        $data = [];
        //get user's production, then the roles relevant to that production, then the choices relevant to those roles
        $production = Productions::where('user_id', $you->id)->first()->show_id;
        $productionRoles = ActorRoles::where('show', $production)->pluck('role_name');
        //change array formatting so keys are usable in vue (numbers are invalid)
        foreach ($productionRoles as $role) {
            $item;
            //this shit needs validation
            $item['name'] = $role;
            array_push($data, $item);
        }

        return view("user.addRole", [
            'roles' => $data,
        ]);
    }

    /**
     * Store a newly created role member in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRole(Request $request)
    {
        $you = auth()->user();
        $production = Productions::where('user_id', $you->id)->first()->show_id;

        $request->validate([
            'name' => 'required',
        ]);

        $role = new ActorRoles();

        $role->role_name = $request->name;
        $role->show = $production;

        $role->save();
        return response()->json([
            'message' => 'Successfully created Role!',
            'id' => $role->id
        ], 201);
    }
}
