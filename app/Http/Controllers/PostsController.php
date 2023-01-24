<?php

namespace App\Http\Controllers;

use App\Models\posts;
use App\Models\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=posts::all();
        $users=User::all();
        return view('posts.posts',compact('posts','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required:posts|max:255',
            'text' => 'required:posts',
            'image' => 'required:posts',
        ],[

            'title.required' =>'please enter post title',
            'text.required' =>'please enter post text',
            'image.required' =>'please choose image',


        ]);

        posts::create([
            'title' => $request->title,
            'text' => $request->text,
            'user_id' => $request->user_id,
            'image' => $request->image,

        ]);
        session()->flash('Add', 'Post added successfully ');
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idd)
    {
        $user_id = User::where('name', $request->user_name)->first()->id;

        $posts = posts::findOrFail($request->id);

        $posts->update([
            'title' => $request->title,
            'text' => $request->text,
            'user_id' => $user_id,
            'image' => $request->image,
        ]);

        session()->flash('edit','Edit Post Done Successfully');
        //return back();
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $posts = posts::findOrFail($request->id);
        $posts->delete();
        session()->flash('delete', 'Delete Post Done Successfully');
        return redirect('/posts');
    }
}
