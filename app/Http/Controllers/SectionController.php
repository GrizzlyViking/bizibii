<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Page $page): Response
    {
        return response(view('admin.section.list', ['sections' => $page->sections()->get()]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response(view('admin.section.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([]);

        Section::create($validated);

        return response()->redirectToRoute('section.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return Response
     */
    public function show(Page $page, Section $section): Response
    {
        return response(view('admin.section.show', compact('section')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return Response
     */
    public function edit(Section $section): Response
    {
        return \response(view('admin.section.edit'), compact('section'));
    }

    /**
     * @param Request $request
     * @param Section $section
     * @return RedirectResponse
     */
    public function update(Request $request, Section $section)
    {
        $validate = $request->validate([]);
        $section->update($validate);

        return response()->redirectToRoute('section.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return RedirectResponse
     */
    public function destroy(Section $section): RedirectResponse
    {
        $section->delete();

        return \response()->redirectToRoute('section.index');
    }
}
