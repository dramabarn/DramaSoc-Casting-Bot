<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Productions;
use App\Models\Shows;
use App\Models\User;
use App\Notifications\ShowCreated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $sharing = $this->getSharingCasts();
        $deadlock = $this->deadlock();

        return view("admin.castingMeeting",
            [
                'productions'=> $productions,
                'productionchoices'=> $productionchoices,
                'casted'=> $casted,
                'freeCast'=> $freeCast,
                'sharing'=> $sharing,
                'deadlocks' => $deadlock
            ]);
    }

    public function castPerson(Request $request){
            $role_id = $request->role_id;
            $role = Choices::where('id', $role_id)->firstOrFail();
            $role->casted = True;
            $role->save();
            return response()->json($role);
    }

    /**
     * Convert choices to vue compatible array
     * @param Collection $choices
     * @return array
     * @deprecated use function in ChoicesController
     */
    private function convertChoices(Collection $choices): array
    {
        return ChoicesController::convertChoices($choices, true);
    }

    public function deleteChoice(Request $request){
        // This is a destructive function - the castings are removed from the database!
        $cast_id = $request->cast_id;
        $choice = $request->choice;
        if($choice == 3){
            //just remove, since it doesn't affect the others
            Choices::where('id', $cast_id)->update(['3rd_choice'=>null]);

        }else if($choice == 2){
            //Set the second choice as third choice and third choice to Null.
            $third = Choices::where('id', $cast_id)->firstOrFail()['3rd_choice'];
            Choices::where('id', $cast_id)->update(['2nd_choice'=>$third, '3rd_choice'=>null]);
        }else if($choice == 1){
            //Set the first choice to second, and second to third an third to null
            $second = Choices::where('id', $cast_id)->firstOrFail()['2nd_choice'];
            $third = Choices::where('id', $cast_id)->firstOrFail()['3rd_choice'];
            Choices::where('id', $cast_id)->update(['1st_choice'=> $second,'2nd_choice'=>$third, '3rd_choice'=>null]);
        }
    }

    /**
     * Truncates relevant tables
     * Very destructive operation!
     * @param Request $request
     */
    public function deleteAll(Request $request){
        $tables = ['actor_roles', 'actors', 'choices', 'productions', 'shows'];
        foreach ($tables as $table){
            DB::table($table)->truncate();
        }
        $delete = DB::delete('delete from users where menuroles not like "%admin%"');
    }

    private function getCastedRoles(): array
    {
        $casts = Choices::all();
        $roles = ActorRoles::all();

        $productionRoles = $roles->pluck('id');
        $choices = $casts->where('casted', True)->whereIn('role_name', $productionRoles);

        return $this->convertChoices($choices);
    }

    private function getChoices(): array
    {
        $casts = Choices::all();
        $choices = $casts->where('casted', False)->sortBy("role_name");

        return $this->convertChoices($choices);
    }

    private function getFreeToCast(): array
    {
        $casts = Choices::all();
        $castings = $casts->where('casted', False);
        //we maintain 3 arrays - single casts, adjacent casts and sharing casts
        $SINGLE_CASTS = array();

        //FIRSTLY, WE NEED TO CHECK FOR NON-CONFLICTS (only looking at 1st choices)
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
                //convert db keys to usable object keys (DAMMIT NATHAN)
                $item;
                $item['id'] = $casting['id'];
                $item['role'] = ActorRoles::where('id',$casting['role_name'])->first()->role_name;
                //i think the line below will cause an error at some point but i'm not certain...
                $item['play'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->name;
                $item['week'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->week;
                $item['type'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->type;
                $item['person'] = Actors::where('id',$casting['1st_choice'])->first()->name;
                $item['phone'] = Actors::where('id',$casting['1st_choice'])->first()->phone;
                array_push($SINGLE_CASTS, $item);
            }
        }

        return $SINGLE_CASTS;
    }

    //TODO: convert this function
    //Will fix https://github.com/dramabarn/DramaSoc-Casting-Bot/issues/14
    private function getWaitingOn(){
        $casts = Choices::all();
        $castings = $casts->where('casted', False);

        $WAITING_ON = array();
        $SINGLE_CAST = false;
        $ANOTHER_FIRST = false;

        $position = 0;

        foreach($castings as $casting){

            array_splice($castings,$position,1);
            $ANOTHER_FIRST = false;
            foreach($castings as $listing){

                if($casting['1st_choice'] == $listing['2nd_choice'] || $casting['1st_choice'] == $listing['3rd_choice']){
                    //They can't be cast until other things have been cast
                    array_push($WAITING_ON, $casting);
                    array_push($WAITING_ON, $listing);
                }

            }

            $position++;

        }
        return $WAITING_ON;
    }

    public function getSharingCasts(){
        // What's the sharing period
        $noSharingWeeks = 1;

        $casts = Choices::all();
        $roles = ActorRoles::all();
        $shows = Shows::all();
        $castings = $casts->where('casted', False);
        $SHARING_PROBLEMS = array();

        foreach($castings as $casting) {
            $castShow = $roles->where('id',$casting['role_name'])->pluck('show');
            $castWeek = $shows->whereIn('id',$castShow)->first()->week;

            foreach ($castings as $others) {
                $share_cast = false;
                // cancles me out
                $otherShow = $roles->where('id',$others['role_name'])->pluck('show');
                $otherWeek = $shows->whereIn('id',$otherShow)->first()->week;

                if($casting['id'] != $others['id']){

                    // if this week is NOT within the 2 week period then check if sharing
                    if($otherWeek > $castWeek + $noSharingWeeks){

                        // if we're sharing be true
                        if($casting['1st_choice'] == $others['1st_choice']){
                            $share_cast = true;
                        }

                    }

                }
                if($share_cast){
                    $data = [];
                    $data['firstid'] = $casting['id'];
                    $data['secondid'] = $others['id'];
                    $data['name'] = Actors::where('id', $casting['1st_choice'])->first()->name;
                    $data['phone'] = Actors::where('id', $casting['1st_choice'])->first()->phone;
                    $data['firstshow'] = $shows->whereIn('id',$castShow)->first()->name;
                    $data['firstweek'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->week;
                    $data['firsttype'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->type;
                    $data['firstrole'] = $roles->where('id',$casting['role_name'])->first()->role_name;
                    $data['secondshow'] = $shows->whereIn('id',$otherShow)->first()->name;
                    $data['secondweek'] = Shows::where('id', ActorRoles::where('id',$others['role_name'])->first()->show)->first()->week;
                    $data['secondtype'] = Shows::where('id', ActorRoles::where('id',$others['role_name'])->first()->show)->first()->type;
                    $data['secondrole'] = $roles->where('id',$others['role_name'])->first()->role_name;
                    array_push($SHARING_PROBLEMS, $data);
                }
            }
        }
        return $SHARING_PROBLEMS;
    }

    public function deadlock(){
        // What's the sharing period
        $noSharingWeeks = env('CASTINGBOT_SHARING_WEEKS', 2);

        $casts = Choices::all();
        $roles = ActorRoles::all();
        $shows = Shows::all();
        $castings = $casts->where('casted', False)->sortBy("1st_choice");

        $deadlock = array();
        //First off get the weeks of the plays

        foreach($castings as $casting) {
            $share_cast = false;
            $castShow = $roles->where('id',$casting['role_name'])->pluck('show');
            $castWeek = $shows->whereIn('id',$castShow)->first()->week;

            foreach ($castings as $others) {
                $share_cast = false;
                // cancels me out
                $otherShow = $roles->where('id',$others['role_name'])->pluck('show');
                $otherWeek = $shows->whereIn('id',$otherShow)->first()->week;

                if($casting['id'] != $others['id']){

                    // if this week is NOT within the 2 week period then check if sharing
                    if($otherWeek <= $castWeek + $noSharingWeeks && $otherWeek >= $castWeek - $noSharingWeeks){
                        // if we're sharing be true
                        if($casting['1st_choice'] == $others['1st_choice']){
                            $share_cast = true;
                        }

                    }

                }
                if($share_cast){
                    $data = [];
                    $data['firstid'] = $casting['id'];
                    $data['secondid'] = $others['id'];
                    $data['name'] = Actors::where('id', $casting['1st_choice'])->first()->name;
                    $data['phone'] = Actors::where('id', $casting['1st_choice'])->first()->phone;
                    $data['firstshow'] = $shows->whereIn('id',$castShow)->first()->name;
                    $data['firstweek'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->week;
                    $data['firsttype'] = Shows::where('id', ActorRoles::where('id',$casting['role_name'])->first()->show)->first()->type;
                    $data['firstrole'] = $roles->where('id',$casting['role_name'])->first()->role_name;
                    $data['secondshow'] = $shows->whereIn('id',$otherShow)->first()->name;
                    $data['secondweek'] = Shows::where('id', ActorRoles::where('id',$others['role_name'])->first()->show)->first()->week;
                    $data['secondtype'] = Shows::where('id', ActorRoles::where('id',$others['role_name'])->first()->show)->first()->type;
                    $data['secondrole'] = $roles->where('id',$others['role_name'])->first()->role_name;
                    array_push($deadlock, $data);
                }
            }
        }
        return $deadlock;
    }

    public function addProduction(Request $request){

        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password'=>'required',
            'email' => 'required',
            'week' => 'required',
            'type' => 'required',
        ]);

        $user =  User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        $show = new Shows();
        $show->name = $request->name;
        $show->week = $request->week;
        $show->type = $request->type;
        $show->save();

        $production = new Productions();
        $production->show_id = $show->id;
        $production->user_id = $user->id;
        $production->save();

        //Send email to new user
        $user->notify(new ShowCreated([
            'email' => $request->email,
            'password' => $request->password,//This is amazingly insecure, and I am very aware of that.
            'show' => $request->name,
            'week' => $request->week,
            'type' => $request->type,
        ]));

        return response()->json([
            'message' => 'Successfully created Production!',
            'id' => $show->id
        ], 201);    }


    public function add(){
        $productions = Shows::getAdditionaldata();
        return view("admin.addPlay", [
            'productions'=>$productions,
        ]);
    }
}
