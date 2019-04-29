<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use PDF;

use User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/home');
    }

    public function home(){
        return view('posts.home');
    }
    
    public function account(){
        return view('pages.account');
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

    public function rota(){
        $dates = $this->week_dates();
        $currWeek = date("W") . '_' . date("Y");
        $positions_obj = DB::table('users')->select('position')->groupBy('position')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $positions = json_decode(json_encode($positions_obj), true);
        $users = DB::table('users')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $rotas = DB::table('rotas')->get();
        $currentUser = auth()->user()->id;
        $singleToShow = DB::table('rotas')->where('user_id', "$currentUser")->where('week_no', "$currWeek")->get();
        return view('pages.rota')->with(compact('users', 'rotas', 'dates', 'currWeek', 'currentUser', 'singleToShow', 'positions'));
    }

    public function toggleWeek($param){
        $weekYearArray = explode('_' , $param);
        $positions_obj = DB::table('users')->select('position')->groupBy('position')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $positions = json_decode(json_encode($positions_obj), true);
        $currWeek = (string)$weekYearArray[0];
        $currentY = (string)$weekYearArray[1];
        $dates = $this->week_dates($date =sprintf("%4dW%02d", $currentY, $currWeek));
        $users = DB::table('users')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $rotas = DB::table('rotas')->get();
        $currentUser = auth()->user()->id;
        $currWeek = implode('_', $weekYearArray);
        $singleToShow = DB::table('rotas')->where('user_id', "$currentUser")->where('week_no', "$currWeek")->get();
        return view('pages.rota')->with(compact('users', 'rotas', 'dates', 'currWeek', 'currentUser', 'singleToShow', 'positions'));
    }


    // test function, to delete once the page is finalized

    public function rotaToPrint($param){
        $weekYearArray = explode('_' , $param);
        $positions_obj = DB::table('users')->select('position')->groupBy('position')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $positions = json_decode(json_encode($positions_obj), true);
        $currWeek = (string)$weekYearArray[0];
        $currentY = (string)$weekYearArray[1];
        $dates = $this->week_dates($date =sprintf("%4dW%02d", $currentY, $currWeek));
        $users = DB::table('users')->orderByRaw("FIELD(position , 'manager', 'supervisor', 'hostess', 'sommelier', 'chef de rang', 'expo', 'commis', 'casual') ASC")->get();
        $rotas = DB::table('rotas')->get();
        $currWeek = implode('_', $weekYearArray);
        return view('pages.rota-toprint')->with(compact('users', 'rotas', 'dates', 'currWeek', 'positions'));
        
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
        $html = view("pages.rota-toprint")->with(compact('users', 'rotas', 'dates', 'currWeek', 'positions'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('rota.pdf');
    }
}
