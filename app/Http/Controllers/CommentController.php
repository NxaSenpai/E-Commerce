<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer'
        ]);
        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => $request->user_id,
            'commentable_type' => $request->commentable_type,
            'commentable_id' => $request->commentable_id
        ]);
        return response()->json($comment, 201);
    }

    public function index()
    {
        $comments = Comment::with('commentable')->get();
        return response()->json($comments);
    }
}
