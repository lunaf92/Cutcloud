<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Rota;

use App\DraftRota;

use App\User;

class DraftsController extends Controller
{

    // init contructor, this will allow only admins to view the pages
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // function to display the days of the week starting from sunday
    // 
    function week_dates($date = null, $format = 'd-m-y', $start = 'sunday') {
        // is date given? if not, use current time...
        if(is_null($date)) $date = 'now';
      
        // get the timestamp of the day that started $date's week...
        $todayDay = date('w', strtotime('today'));
        if ($todayDay == 0){
            $weekstart = strtotime($start, strtotime($date));
        }else{
            $weekstart = strtotime('last '.$start, strtotime($date));
        }
      
        // add 86400 to the timestamp for each day that follows it...
        for($i = 0; $i < 7; $i++) {
            $day = $weekstart + (86400 * $i);
            if(is_null($format)) $dates[$i] = $day;
            else $dates[$i] = date($format, $day);
        }
      
        return $dates;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.rota-draft');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $param)
    {
        $users = DB::table('users')->get();
        foreach($users as $user){
            
         //validation
         $this->validate($request,[
            $user->id . '_user_id' => 'required',
            $user->id . '_week_no'=> 'required'
        ]);
        
            //create a field
            $rota = new DraftRota;
            $rota->user_id = $request->input($user->id . '_user_id');
            $rota->week_no = $request->input($user->id . '_week_no');
            $rota->sunday = $request->input($user->id . '_sunday');
            $rota->monday = $request->input($user->id . '_monday');
            $rota->tuesday = $request->input($user->id . '_tuesday');
            $rota->wednesday = $request->input($user->id . '_wednesday');
            $rota->thursday = $request->input($user->id . '_thursday');
            $rota->friday = $request->input($user->id . '_friday');
            $rota->saturday = $request->input($user->id . '_saturday');
            $rota->save();
        }

        return redirect('rota-draft/'.$param)->with('success', 'Draft Updated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param){
        $weekYearArray = explode('_' , $param);
        $positions_obj = DB::table('users')->select('position')->groupBy('position')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $positions = json_decode(json_encode($positions_obj), true);
        $currWeek = (string)$weekYearArray[0];
        $currentY = (string)$weekYearArray[1];
        $dates = $this->week_dates($date =sprintf("%4dW%02d", $currentY, $currWeek));
        $users = DB::table('users')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $currWeek = implode('_', $weekYearArray);
        $rotas = DraftRota::where('week_no', $currWeek)->orderBy('user_id', 'asc')->get();
        //get all the instances of the 
        return view('admin.rota-draft')->with(compact('users', 'dates', 'currWeek', 'rotas', 'positions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $toUpdate = DraftRota::where('week_no', $id)->get();
        if((count($toUpdate) == 0)){
            return $this->store($request, $id);
        }
        else{
            $this->destroy($id);
            return $this->store($request, $id);
        }
    }

    public function destroy($id){
        $rota = DraftRota::where('week_no', $id)->get();
        $rota->each->delete();
        return;
    }
}
