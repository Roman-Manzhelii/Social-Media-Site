<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::with('user')->paginate(10);
        return view('posts.index', compact('posts'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'graphicContent' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:100000',

        ]);
    
        $newGraphicContentName = uniqid() . '.' . $request->graphicContent->extension();
        $request->graphicContent->move(public_path('graphic_content'), $newGraphicContentName);

        $post = new Post;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        $post->path = $newGraphicContentName;
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('posts.show', compact('posts'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('posts'));
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
        $request->validate([
            'description' => 'required',
            'graphicContent' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:100000',
        ]);
    
        $Post = Post::findOrFail($id);
        
        if ($request->hasFile('graphicContent')) {
            if ($post->path && file_exists(public_path('graphic_content/' . post->path))) {
                unlink(public_path('graphic_content/' . post->path));
            }
            $newGraphicContentName = uniqid() . '.' . $request->graphicContent->extension();
            $request->graphicContent->move(public_path('graphic_content'), $newGraphicContentName);
        }

    $post->description = $request->description;
    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
}
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
    
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
    
}