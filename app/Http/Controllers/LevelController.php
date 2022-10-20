<?php

namespace App\Http\Controllers;

use App\Models\level;
use App\Http\Requests\StorelevelRequest;
use App\Http\Requests\UpdatelevelRequest;
use Illuminate\Support\Facades\Schema;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Schema::getColumnListing('comments');
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
     * @param  \App\Http\Requests\StorelevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorelevelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelevelRequest  $request
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelevelRequest $request, level $level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(level $level)
    {
        //
    }
}
