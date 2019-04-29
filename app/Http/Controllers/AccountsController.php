<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use App\Admin;

use Illuminate\Support\Facades\Hash;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getAuthUser ()
    {
        return Auth::user();
    }

    public function index(){
        return view('admin.manageAccounts.index');
    }

    public function email(){
        $user = Admin::find(Auth::id());
        return view('admin.manageAccounts.email')->with(compact('user'));
    }

    public function updateEmail(Request $request, $id){
        
        $this->validate($request, [
            'email' => 'required|email|unique:admins'
        ]);
        $user = Admin::find($id);
        
        if($user->email == $request->input('oldMail')){
            $user->email = $request->input('email');
            $user->save();
            return redirect('/manageAccounts')->with('success', 'email updated');
        }
        else{
            return redirect('/manageAccounts')->with('error', 'email doesn\'t match');
        }   
    }


    public function password(){
        $user = Admin::find(Auth::id());
        return view('admin.manageAccounts.password')->with(compact('user'));
    }

    public function updatePassword(Request $request, $id){
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = Admin::find($id);

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/manageAccounts')->with('success', 'password updated');
    }

    public function users(){
        $users = User::orderBy('first_name')->get();
        return view('admin.manageAccounts.manageUsers')->with(compact('users'));
    }

    public function editUser($id){
        $user = User::find($id);
        return view('admin.manageAccounts.editUser')->with(compact('user'));
    }

    public function updateUser(Request $request, $id){
        $userToUpdate = User::find($id);
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required',
            'position' => 'required'
        ]);
        $userToUpdate->first_name = $request->input('first_name');
        $userToUpdate->last_name = $request->input('last_name');
        $userToUpdate->email = $request->input('email');
        $userToUpdate->position = $request->input('position');
        $userToUpdate->save();
        return $this->editUser($id)->with('success', 'user edited successfully!');
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect('/manageUsers')->with('success', 'User deleted');
    }
}
