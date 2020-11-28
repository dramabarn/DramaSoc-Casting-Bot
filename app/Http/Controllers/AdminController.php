<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\ActorRoles;
use App\Models\Actors;
use App\Models\Choices;
use App\Models\Productions;
use App\Models\Shows;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Commands\Show;

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

    private function convertChoices($choices){
        $shows = Shows::all();
        //change array formatting so keys are usable in vue (numbers are invalid)
        $data = [];
        foreach ($choices as $choice){
            $item;
            $showId = ActorRoles::where('id',$choice['role_name'])->first()->show;
            //this shit needs validation

            $item['show'] = $shows->where('id',$showId)->first()->name;
            $item['week'] = $shows->where('id',$showId)->first()->week;
            $item['type'] = $shows->where('id',$showId)->first()->type;
            $item['role'] = ActorRoles::where('id',$choice['role_name'])->first()->role_name;

            $actor = Actors::where('id',$choice['1st_choice'])->first();
            $item['first'] = !empty($actor->name) ? $actor->name:'';

            $actor = Actors::where('id',$choice['1st_choice'])->first();
            $item['firstid'] = !empty($actor->id) ? $actor->id:'';

            $actor = Actors::where('id',$choice['2nd_choice'])->first();
            $item['second'] = !empty($actor->name) ? $actor->name:'';

            $actor = Actors::where('id',$choice['2nd_choice'])->first();
            $item['secondid'] = !empty($actor->id) ? $actor->id:'';

            $actor = Actors::where('id',$choice['3rd_choice'])->first();
            $item['third'] = !empty($actor->name) ? $actor->name:'';

            $actor = Actors::where('id',$choice['3rd_choice'])->first();
            $item['thirdid'] = !empty($actor->id) ? $actor->id:'';

            array_push($data,$item);
        }

        return $data;
    }

    public function deleteChoice(Request $request){
        $role_id = $request->

        $role = Choices::where('id', $role_id)->firstOrFail();


        if($choice == 3){
                //Do Nothing, since it doesn't affect the others
                $this->db->where('casting_id',$casting);
                $this->db->update('casting',array('third_choice'=>0));

            }else if($choice == 2){
                //Set the third choice as second choice.
                $this->db->where('casting_id',$casting);
                $this->db->update('casting',array('second_choice'=>$CASTING_CHOICES['third_choice']));

                $this->db->where('casting_id',$casting);
                $this->db->update('casting',array('third_choice'=>0));

            }else if($choice == 1){
                //Set the first choice to second, and second to third an third to 0
                $this->db->where('casting_id',$casting);
                $this->db->update('casting',array('first_choice'=>$CASTING_CHOICES['second_choice']));

                $this->db->where('casting_id',$casting);
                $this->db->update('casting',array('second_choice'=>$CASTING_CHOICES['third_choice']));

                $this->db->where('casting_id',$casting);
                $this->db->update('casting',array('third_choice'=>0));

            }

            $this->db->select("*");
            $this->db->from('casting');
            $this->db->where('casting_id',$casting);
            $query = $this->db->get();
            $CASTING_CHOICES = $query->row_array();

            if(($CASTING_CHOICES['first_choice'] == 0) && ($CASTING_CHOICES['second_choice'] == 0) && ($CASTING_CHOICES['third_choice'] == 0)){
                //Delete the whole row
                $this->db->where('casting_id',$casting);
                $this->db->delete('casting');
            }

    }

    private function getCastedRoles(){
        $casts = Choices::all();
        $roles = ActorRoles::all();

        $productionRoles = $roles->pluck('id');
        $choices = $casts->where('casted', True)->whereIn('role_name', $productionRoles);

        return $this->convertChoices($choices);
    }

    private function getChoices(){
        $casts = Choices::all();
        $choices = $casts->where('casted', False)->sortBy("role_name");

        return $this->convertChoices($choices);
    }

    private function getFreeToCast(){
        $casts = Choices::all();
        $castings = $casts->where('casted', False);
        //we maintain 3 arrays - single casts, adjacent casts and sharing casts
        $SINGLE_CASTS = array();

        //FIRSTLY, WE NEED TO CHECK FOR NON-CONFLICTS (only looking at 1st choices)
        $over_1 = true;
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
                $over_1 = true;
            }
        }

        return $SINGLE_CASTS;
    }

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
        $noSharingWeeks = 2;

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
        $noSharingWeeks = 2;

        $casts = Choices::all();
        $roles = ActorRoles::all();
        $shows = Shows::all();
        $castings = $casts->where('casted', False);

        $deadlock = array();
        //First off get the weeks of the plays

        foreach($castings as $casting) {
            $share_cast = false;
            $castShow = $roles->where('id',$casting['role_name'])->pluck('show');
            $castWeek = $shows->whereIn('id',$castShow)->first()->week;

            foreach ($castings as $others) {
                $share_cast = false;
                // cancles me out
                $otherShow = $roles->where('id',$others['role_name'])->pluck('show');
                $otherWeek = $shows->whereIn('id',$otherShow)->first()->week;

                if($casting['id'] != $others['id']){

                    // if this week is NOT within the 2 week period then check if sharing
                    if($otherWeek <= $castWeek + $noSharingWeeks){
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

        return response()->json([
            'message' => 'Successfully created Production!',
            'id' => $show->id
        ], 201);    }


    public function add(){
        $productions = Shows::all();

        return view("admin.addPlay",
        [            'productions'=>$productions,
        ]);
    }


    public function view(){
        $productions = Shows::all();

        return view("admin.viewProductions",
        [            'productions'=>$productions,
        ]);
    }

    public function people(){

        $actors = Actors::all();

        return view("admin.people",[
            'people'=>$actors,
        ]);
    }

}
