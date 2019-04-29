<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
# in order to access the posts table is necessary to bring in the model associated with it
use App\Post; 
# add DataBase library in order to use SQL queries
use DB;



class AdminPostsController extends Controller
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
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin-posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-posts.create');
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
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:4999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')){
            // Get filename with the extention
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extention
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }else{
            $filenameToStore = 'noimage.jpg';
        }
        
        // Create a Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user('admin')->id;
        $post->cover_image = $filenameToStore;
        $post->save();

        return redirect('/admin-post')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('admin-posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // check for correct user
        $post = Post::find($id);

        return view('admin-posts.edit')->with('post', $post);
        
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
         //validation
         $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:4999'
        ]);
        
        // Handle file upload
        if($request->hasFile('cover_image')){
            // Get filename with the extention
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extention
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }

        // Update Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            Storage::delete('public/cover_images/'.$post->cover_image);
            $post->cover_image = $filenameToStore;
        }
        $post->save();

        return redirect('/admin-post')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if($post->cover_image != 'noimage.jpg'){
            //Delete image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/admin-post')->with('success', 'Post Deleted');
    }
}