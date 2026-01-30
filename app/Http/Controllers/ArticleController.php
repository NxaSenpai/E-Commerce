<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id'
        ]);
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function subscribe(Request $request, Article $article)
    {
        $request->validate(['audience_id' => 'required|exists:audiences,id']);
        $article->audiences()->attach($request->audience_id);
        return response()->json(['message' => 'Subscribed']);
    }

    public function audiences(Article $article)
    {
        return response()->json($article->audiences);
    }
}
