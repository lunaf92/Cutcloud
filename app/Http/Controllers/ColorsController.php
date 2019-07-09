<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Colors;

use App\User;

class ColorsController extends Controller
{
    //

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
            $color = new DraftRota;
            $color->user_id = $request->input($user->id . '_user_id');
            $color->week_no = $request->input($user->id . '_week_no');
            $color->sunday = $request->input('color'.$user->id . '_sunday_color');
            $color->monday = $request->input('color'.$user->id . '_monday');
            $color->tuesday = $request->input('color'.$user->id . '_tuesday');
            $color->wednesday = $request->input('color'.$user->id . '_wednesday');
            $color->thursday = $request->input('color'.$user->id . '_thursday');
            $color->friday = $request->input('color'.$user->id . '_friday');
            $color->saturday = $request->input('color'.$user->id . '_saturday');
            $color->save();
        }

        return redirect('admin-rota/'.$param)->with('success', 'colors saved!!');
    }
}
