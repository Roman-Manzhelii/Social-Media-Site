<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate(['content' => 'required|string']);
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id();
        $comment->post_id = $postId; // Ensure this matches your database structure
        $comment->save();
    
        return back()->with('success', 'Comment added successfully.');
    }
    
    public function update(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (auth()->id() !== $comment->user_id) {
            return back()->with('error', 'Unauthorized access.');
        }
        $request->validate(['content' => 'required|string']);
        $comment->content = $request->content;
        $comment->save();
    
        return back()->with('success', 'Comment updated successfully.');
    }
    
    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (auth()->id() !== $comment->user_id) {
            return back()->with('error', 'Unauthorized access.');
        }
        $comment->delete();
    
        return back()->with('success', 'Comment deleted successfully.');
    }
}
