<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios=Portfolio::with('Category')->get();
        return view('admin.portfolio.index',compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        $portfolio=new Portfolio();
        return view('admin.portfolio.create',compact('categories','portfolio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:4',
            'project_url' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',
            'category_id' => 'required|exists:categories,id'
        ]);
        $img = $request->file('image');
        $img_name = rand(). time().$img->getClientOriginalName();
        $img->move(public_path('uploads/portfolio'), $img_name);

        Portfolio::create([
            'title'=>$request->title,
            'project_url'=>$request->project_url,
            'image'=>$img_name,
            'category_id'=>$request->category_id,
        ]);
        return redirect()->route('admin.portfolio.index')->with('msg','Portfolio Added Successfully');
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
    public function edit($id)
    {
        $portfolio=Portfolio::findOrFail($id);
        $categories = Category::all();

        return view('admin.portfolio.edit', compact('portfolio','categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|min:4',
            'project_url' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',
            'category_id' => 'required|exists:categories,id'
        ]);
        $portfolio=Portfolio::findOrFail($id);

        // Upload Images
        $img_name = $portfolio->image;
        if($request->hasFile('image')) {
            File::delete(public_path('uploads/portfolio/'.$portfolio->image));
            $img = $request->file('image');
            $img_name = rand().time().$img->getClientOriginalName();
            $img->move(public_path('uploads/portfolio/'), $img_name);
        }
        $portfolio->update([
            'title'=>$request->title,
            'project_url'=>$request->project_url,
            'image'=>$img_name,
            'category_id'=>$request->category_id,
        ]);
        return redirect()->route('admin.portfolio.index')->with('msg', 'Portfolio updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portfolio=portfolio::findOrFail($id);
        File::delete(public_path('uploads/portfolio/'.$portfolio->image));
        $portfolio -> delete();
        return back()->with('message', 'Review Deleted');
    }
}
