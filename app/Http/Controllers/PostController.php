<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('user')->paginate(10);
        return view('posts.index', compact('posts'));
    }
    

    public function create()
    {
        return view('posts.create');
    }


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
    

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized access.');
        }
        return view('posts.edit', compact('post'));
    }


    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'description' => 'required',
            'graphicContent' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,qt|max:100000',
        ]);

        if ($request->hasFile('graphicContent')) {
            if ($post->path && file_exists(public_path('graphic_content/' . $post->path))) {
                unlink(public_path('graphic_content/' . $post->path));
            }
            $newGraphicContentName = uniqid() . '.' . $request->graphicContent->extension();
            $request->graphicContent->move(public_path('graphic_content'), $newGraphicContentName);
            $post->path = $newGraphicContentName;
        }

        $post->description = $request->description;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (auth()->id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'Unauthorized access.');
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}