<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_obj = DB::table('menus')->select('category')->groupBy('category')->orderByRaw("FIELD(category , 'breakfast', 'starters', 'mains', 'dessert', 'rough cuts', 'wine', 'cocktails', 'spirits') ASC")->get();
        $categories = json_decode(json_encode($categories_obj), true);
        $menus = Menu::orderBy('name')->get();
        return view('admin-menu.index')->with(compact('menus', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request,[
            'category' => 'required',
            'name' => 'required | unique:menus',
            'menu_description' => 'required|max:19999'
        ]);

        // Handle file upload
        if($request->hasFile('menu_description')){
            // Get filename with the extention
            $filenameWithExt = $request->file('menu_description')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extention
            $extension = $request->file('menu_description')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('menu_description')->storeAs("public/menu_description/{$request->input('category')}", $filenameToStore);
        }

        // Create a Post
        $menu = new Menu;
        $menu->category = $request->input('category');
        $menu->name = $request->input('name');
        $menu->menu_description = $filenameToStore;
        $menu->save();

        return redirect('/admin-menu')->with('success', 'Menu item added');
    }

    public function edit($id){
        // find SOP
        $menu = Menu::find($id);

        return view('admin-menu.update')->with('menu', $menu);
    }

    public function update(Request $request, $id){
        //validation
        $this->validate($request,[
            'menu_description' => 'max:19999'
        ]);

        // Handle file upload
        if($request->hasFile('menu_description')){
            // Get filename with the extention
            $filenameWithExt = $request->file('menu_description')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extention
            $extension = $request->file('menu_description')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('menu_description')->storeAs("public/menu_description", $filenameToStore);
        }

        // update menu item
        $menu = Menu::find($id);
        if($request->hasFile('menu_description')){
            Storage::delete('public/menu_description/'.$menu->menu_description);
            $menu->menu_description = $filenameToStore;
        }
        $menu->save();

        return redirect('/admin-menu')->with('success', 'menu item updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu_item = Menu::find($id);

        Storage::delete('/storage/menu_description//'.$menu_item->category.'/'.$menu_item->menu_description);

        $menu_item->delete();
        return redirect('/admin-menu')->with('success', 'Item Deleted');
    }
}
