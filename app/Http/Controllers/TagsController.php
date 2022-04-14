<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagsRequest;
use App\Http\Requests\UpdateTagsRequest;
use App\Models\Tag;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag $tags
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tags
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagsRequest  $request
     * @param \App\Models\Tag  $tags
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagsRequest $request, Tag $tags)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag  $tags
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tags)
    {
        //
    }
}
