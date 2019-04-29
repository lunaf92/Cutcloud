<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\SOP;

use App\Menu;

class MenuSopStaff extends Controller
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
    
    public function index_sop()
    {
        $categories_obj = DB::table('s_o_ps')->select('category')->groupBy('category')->orderByRaw("FIELD(category , 'Service', 'Communication', 'Health & Safety', 'Facilities', 'Grooming') ASC")->get();
        $categories = json_decode(json_encode($categories_obj), true);
        $sops = SOP::orderBy('name')->get();
        return view('pages.sop')->with(compact('sops', 'categories'));
    }

    public function index_menu()
    {
        $categories_obj = DB::table('menus')->select('category')->groupBy('category')->orderByRaw("FIELD(category , 'breakfast', 'starters', 'mains', 'dessert', 'rough cuts', 'wine', 'cocktails', 'spirits') ASC")->get();
        $categories = json_decode(json_encode($categories_obj), true);
        $menus = Menu::orderBy('name')->get();
        return view('pages.menudesc')->with(compact('menus', 'categories'));
    }
}
