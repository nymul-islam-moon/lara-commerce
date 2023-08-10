<?php


namespace App\Http\Controllers\Admin;

use App\Models\ChildCategory;
use App\Http\Requests\StoreChildCategoryRequest;
use App\Http\Requests\UpdateChildCategoryRequest;

class ChildCategoryController extends Controller
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
     * @param  \App\Http\Requests\StoreChildCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChildCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ChildCategory $childCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ChildCategory $childCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChildCategoryRequest  $request
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChildCategoryRequest $request, ChildCategory $childCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChildCategory $childCategory)
    {
        //
    }
}
