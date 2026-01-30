<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string',
            'user_name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $author = Author::create([
            'name' => $request->author_name,
            'user_id' => $user->id
        ]);
        return response()->json($author, 201);
    }

    public function articles(Author $author)
    {
        return response()->json($author->articles);
    }

    public function audiences(Author $author)
    {
        return response()->json($author->audiences);
    }
}
