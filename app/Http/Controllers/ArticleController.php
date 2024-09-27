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

    public function show($article)
    {
        // Use Eloquent query with relationships to retrieve the article with comments and users
        $articleWithComments = Article::with(['comments.user'])
            ->where('id', $article)
            ->firstOrFail();

        // Return the view with the article and its comments
        return view('articles.show', [
            'article' => $articleWithComments,
        ]);
    }

    public function edit($id)
    {
        // Retrieve the article by its id
        $article = Article::findOrFail($id);

        // Retrieve all categories
        $categories = Category::all();

        // Pass the article and categories to the view
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Retrieve the article by its ID
        $article = Article::findOrFail($id);

        // Update the article with the request data
        $article->update($request->all());

        // Redirect to the articles index
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }
    public function destroy($id)
    {
        // Retrieve the article by its ID
        $article = Article::findOrFail($id);

        // Delete the article
        $article->delete();

        // Redirect to the articles index
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
