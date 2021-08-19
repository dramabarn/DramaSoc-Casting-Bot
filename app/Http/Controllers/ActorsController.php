<?php

namespace App\Http\Controllers;

use App\Models\Actors;
use Illuminate\Contracts\View\View;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(){
        $actors = Actors::all();

        return view("admin.actors",[
            'people'=>$actors,
        ]);
    }
}
