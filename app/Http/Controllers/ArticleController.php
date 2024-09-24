<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

// app/Http/Controllers/ArticleController.php
class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category', 'user')->where('status', 'unpublished')->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'content' => 'required']);
        $request->merge(['user_id' => auth()->id()]);
        Article::create($request->all());
        return redirect()->route('articles.index');
    }

    public function show(Article $article)
{
    // Load the comments with the associated user
    $article->load('comments.user');

    // Return the view with the article and its comments
    return view('articles.show', [
        'article' => $article,
    ]);
}


    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate(['title' => 'required', 'content' => 'required']);
        $article->update($request->all());
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
