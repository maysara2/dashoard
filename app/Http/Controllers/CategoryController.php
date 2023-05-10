<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        return view('admin.category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $s = $request->validate([
            'name'=>'required',
        ]);
        Category::create($s);
        return redirect()->route('admin.category.index','New Category Added');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $category=Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
       $request->validate([
        'name'=>'required',
    ]);
        $category=Category::findOrFail($id);

        $category->update([
            'name'=>$request->name
        ]);
        return redirect()->route('admin.category.index')->with('message','Category Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $category->delete();
        return request()->route('admin.category.index')->with('message','Category Deleted');
    }
}
