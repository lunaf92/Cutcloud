<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
# in order to access the posts table is necessary to bring in the model associated with it
use App\Post; 
# add DataBase library in order to use SQL queries
use DB;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
        * Fetch all the data from the database and pass them to the view
        * all the data will be fetched in order, the most recently modified first 
        */
        $posts = Post::orderBy('updated_at', 'desc')->paginate(10);
        return view('posts.home')->with('posts', $posts);
    }

    
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // fetch a single post
        $post = Post::find($id);
        return view('posts.post')->with('post', $post);
    }

}
