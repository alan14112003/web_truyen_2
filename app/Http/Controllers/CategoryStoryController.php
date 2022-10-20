<?php

namespace App\Http\Controllers;

use App\Models\CategoryStory;
use App\Http\Requests\StoreCategoryStoryRequest;
use App\Http\Requests\UpdateCategoryStoryRequest;

class CategoryStoryController extends Controller
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
     * @param  \App\Http\Requests\StoreCategoryStoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryStoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryStory  $categoryStory
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryStory $categoryStory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryStory  $categoryStory
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryStory $categoryStory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryStoryRequest  $request
     * @param  \App\Models\CategoryStory  $categoryStory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryStoryRequest $request, CategoryStory $categoryStory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryStory  $categoryStory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryStory $categoryStory)
    {
        //
    }
}
