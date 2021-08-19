<?php

namespace App\Http\Controllers;

use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Shows;
use Illuminate\Contracts\View\View;

class ShowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(){
        $shows = Shows::getAdditionaldata();
        return view("admin.viewProductions", [
            'productions'=>$shows,
        ]);
    }

    public function adminSingle($id){
        $production = Shows::getAdditionalData($id);

        return view("admin.viewSingle",[
            'productions'=>$production,
            'productionChoices'=> ChoicesController::showChoices($id),
        ]);
    }

    public function userSingle($id){
        return view("user.choices",[
            'productionChoices'=>ChoicesController::showChoices($id),
        ]);
    }
}
