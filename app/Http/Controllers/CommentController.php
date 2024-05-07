<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, $reviewId)
    {
        $request->validate(['body' => 'required|string']);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $comment->review_id = $reviewId; // Ensure this matches your database structure
        $comment->save();
    
        return back()->with('success', 'Comment added successfully.');
    }
    
    public function update(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (auth()->id() !== $comment->user_id) {
            return back()->with('error', 'Unauthorized access.');
        }
        $request->validate(['body' => 'required|string']);
        $comment->body = $request->body;
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
