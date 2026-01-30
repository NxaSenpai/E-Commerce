<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;

class AudienceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'audience_name' => 'required|string',
            'user_name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $audience = Audience::create([
            'name' => $request->audience_name,
            'user_id' => $user->id
        ]);
        return response()->json($audience, 201);
    }

    public function comments(Audience $audience)
    {
        return response()->json($audience->comments);
    }
}
