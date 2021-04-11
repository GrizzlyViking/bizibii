<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Article::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.article.create')->withSlot('here be dragons');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required',
            'section' => 'required',
            'title' => 'required',
            'content' => 'required|min:5'
        ]);

        if ($validated) {
            Article::updateOrCreate([
                'page'    => $validated['page'],
                'section' => $validated['section'],
            ], [
                'page'    => $validated['page'],
                'section' => $validated['section'],
                'title'   => $validated['title'],
                'content' => $validated['content'],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return response(view('admin.article.show', $article));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return response(view('admin.article.edit', $article));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'page' => 'required',
            'section' => 'required',
            'title' => 'required',
            'content' => 'required|min:5'
        ]);

        if ($validated) {
            Article::updateOrCreate([
                'page'    => $validated['page'],
                'section' => $validated['section'],
            ], [
                'page'    => $validated['page'],
                'section' => $validated['section'],
                'title'   => $validated['title'],
                'content' => $validated['content'],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        $title = $article->title;
        $article->delete();

        return response()->redirectToRoute('article.index')->with('flash', 'Article: ' . $title . ' deleted.');
    }
}
