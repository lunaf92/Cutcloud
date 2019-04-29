<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\DraftRota;

use App\Rota;

use App\User;

use PDF;


class RotaController extends Controller
{

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
        return view('admin.rota_index');
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
        foreach ($users as $user){
            // validation
            $this->validate($request, [
                $user->id . '_user_id' => 'required',
                $user->id . '_week_no' => 'required',
                $user->id . '_sunday' => 'required',
                $user->id . '_monday' => 'required',
                $user->id . '_tuesday' => 'required',
                $user->id . '_wednesday' => 'required',
                $user->id . '_thursday' => 'required',
                $user->id . '_friday' => 'required',
                $user->id . '_saturday' => 'required',
            ]);

            //create new field
            $rota = new Rota;
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
        
        return redirect('admin-rota/'.$param);
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
        $rotas = Rota::where('week_no', $currWeek)->orderBy('id')->get();
        $draftRotas = DraftRota::where('week_no', $currWeek)->orderBy('id')->get(); 
        //get all the instances of the rota
        return view('admin.admin-rota')->with(compact('users', 'dates', 'currWeek', 'rotas', 'draftRotas', 'positions'));
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
        $toUpdate = Rota::where('week_no', $id)->get();
        /**
         * in this project, the draft needs to be always up-to-date with the actual rota, because in case of changes
         * it needs to act as a playground to fiddle wth while looking for the optimal solution
         * 
         * to implement this the applcation will first look for an eventual existing entry in the database for the draft
         * if not found it will create new rows to copy the existing one
         * 
         * if found it will update it.
         */
        $draftToUpdate = DB::table('draft_rotas')->where('week_no', $id)->get();
        $users = DB::table('users')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        
        if(count($draftToUpdate) == 0){

            //create new draft == rota
            foreach($users as $user){
                
            //validation
            $this->validate($request,[
                $user->id . '_user_id' => 'required',
                $user->id . '_week_no'=> 'required'
            ]);
                // create a field
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
        }else{
            //update
            app('App\Http\Controllers\DraftsController')->update($request, $id);
        };

        
        /**
         * now do the same thing as above with the rota table
         */
        if(count($toUpdate) == 0){
            return $this->store($request, $id);
        }else{
            $this->destroy($id);
            return $this->store($request, $id)->with('success', 'Rota Updated');
        }
    }

    public function destroy($id){
        $rota = Rota::where('week_no', $id)->get();
        $rota->each->delete();
        return;
    }

    public function pdf($param){
        $weekYearArray = explode('_' , $param);
        $positions_obj = DB::table('users')->select('position')->groupBy('position')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $positions = json_decode(json_encode($positions_obj), true);
        $currWeek = (string)$weekYearArray[0];
        $currentY = (string)$weekYearArray[1];
        $dates = $this->week_dates($date =sprintf("%4dW%02d", $currentY, $currWeek));
        $users = DB::table('users')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $rotas = DB::table('rotas')->get();
        $currWeek = implode('_', $weekYearArray);
        $html = view('pages.rota-toprint')->with(compact('users', 'rotas', 'dates', 'currWeek', 'positions'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('rota.pdf');
    }
}
