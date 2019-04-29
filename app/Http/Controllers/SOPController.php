<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SOP;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

class SOPController extends Controller
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
        $categories_obj = DB::table('s_o_ps')->select('category')->groupBy('category')->orderByRaw("FIELD(category , 'Service', 'Communication', 'Health & Safety', 'Facilities', 'Grooming') ASC")->get();
        $categories = json_decode(json_encode($categories_obj), true);
        $sops = SOP::orderBy('name')->get();
        return view('admin-sop.index')->with(compact('sops', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-sop.create');
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
            'name' => 'required | unique:s_o_ps',
            'SOP_description' => 'required|max:19999'
        ]);

        // Handle file upload
        if($request->hasFile('SOP_description')){
            // Get filename with the extention
            $filenameWithExt = $request->file('SOP_description')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extention
            $extension = $request->file('SOP_description')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('SOP_description')->storeAs("public/SOP_description", $filenameToStore);
        }

        // Create a new SOP
        $sop = new SOP;
        $sop->category = $request->input('category');
        $sop->name = $request->input('name');
        $sop->SOP_description = $filenameToStore;
        $sop->save();

        return redirect('/admin-sop')->with('success', 'SOP item added');
    }

    public function edit($id){
        // find SOP
        $sop = SOP::find($id);

        return view('admin-sop.update')->with('sop', $sop);
    }

    public function update(Request $request, $id){
        //validation
        $this->validate($request,[
            'SOP_description' => 'max:19999'
        ]);

        // Handle file upload
        if($request->hasFile('SOP_description')){
            // Get filename with the extention
            $filenameWithExt = $request->file('SOP_description')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extention
            $extension = $request->file('SOP_description')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('SOP_description')->storeAs("public/SOP_description", $filenameToStore);
        }

        // update SOP
        $sop = SOP::find($id);
        if($request->hasFile('SOP_description')){
            Storage::delete('public/SOP_description/'.$sop->SOP_description);
            $sop->SOP_description = $filenameToStore;
        }
        $sop->save();

        return redirect('/admin-sop')->with('success', 'SOP item updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SOP_item = SOP::find($id);

        $file_pointer = 'storage/SOP_description/'.$SOP_item->SOP_description;
        
        $SOP_item->delete();

        if (!unlink($file_pointer))
        {
            return redirect('/admin-sop')->with('error', 'Item cannot be deleted due to an error');
        }
        else
        {
            return redirect('/admin-sop')->with('success', 'Item Deleted');
        };

    }
}