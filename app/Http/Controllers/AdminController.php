<?php

namespace App\Http\Controllers;

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
        return view("admin.index");
    }

    public function people(){
        return view("admin.index");
    }

}
