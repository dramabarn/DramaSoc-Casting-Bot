<?php

namespace App\Http\Controllers;

use App\Models\Productions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $users = User::all();

        return view("admin.users", [
            "people" => $users
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //remove associated production
        $prods = Productions::all();
        $shows = Shows::all();
        $thisProd = $prods->where('user_id', $id)->first();
        $thisShow = $shows->where('id', $thisProd->show_id);
        $thisShow->delete();
        $thisProd->delete();

        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}
