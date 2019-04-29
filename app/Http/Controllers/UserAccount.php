<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use Illuminate\Support\Facades\Hash;

class UserAccount extends Controller
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
    
    public function getAuthUser ()
    {
        return Auth::user();
    }

    public function email(){
        $user = User::find(Auth::id());
        return view('userAccount.emailUpdate')->with(compact('user'));
    }

    public function updateEmail(Request $request, $id){
        
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        $user = User::find($id);
        
        if($user->email == $request->input('oldMail')){
            $user->email = $request->input('email');
            $user->save();
            return redirect('/account')->with('success', 'email updated');
        }
        else{
            return redirect('/account')->with('error', 'email doesn\'t match');
        }   
    }

    public function password(){
        $user = User::find(Auth::id());
        return view('userAccount.passwordUpdate')->with(compact('user'));
    }

    public function updatePassword(Request $request, $id){
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::find($id);

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/account')->with('success', 'password updated');
    }
}
