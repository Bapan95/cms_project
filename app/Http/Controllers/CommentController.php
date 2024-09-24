<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

// app/Http/Controllers/CommentController.php
class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all(); // Fetch all comments
        return view('comments.index', compact('comments')); // Return a view with comments
    }
    public function store(Request $request)
    {
        $request->validate(['content' => 'required']);
        $request->merge(['user_id' => auth()->id()]);
        Comment::create($request->all());
        return redirect()->route('comments.index');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['approved' => true]);
        return redirect()->route('articles.index');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
}
