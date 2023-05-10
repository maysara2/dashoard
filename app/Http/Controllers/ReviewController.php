<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews=Review::all();


        return view('admin.review.index',compact('reviews'));

    }

    /**   * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.review.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'job' => 'required',
            'description' => 'required|min:10|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',
        ]);
        $img = $request->file('image');
        $img_name = rand(). time().$img->getClientOriginalName();
        $img->move(public_path('uploads/reviews'), $img_name);

        Review::create([
            'name'=>$request->name,
            'job'=>$request->job,
            'description'=>$request->description,
            'image'=>$img_name,

        ]);

        return redirect()->route('admin.review.index')->with('message','Review Added');
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
    public function edit(Review $review)
    {
        return view('admin.review.edit',compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:4',
            'job' => 'required',
            'description' => 'required|min:10|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,gif'
        ]);

        $review=Review::findOrFail($id);

       // Upload Images
       $img_name = $review->image;
       if($request->hasFile('image')) {
           File::delete(public_path('uploads/reviews/'.$review->image));
           $img = $request->file('image');
           $img_name = rand().time().$img->getClientOriginalName();
           $img->move(public_path('uploads/reviews/'), $img_name);
       }
        $review->update([
            'name'=>$request->name,
            'job'=>$request->job,
            'description'=>$request->description,
            'image'=>$img_name,
        ]);
        return redirect()->route('admin.review.index')->with('message','Review Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
     {
        // if($review->image != null){
        //     Storage::delete($review->image);
        // }
        $review=Review::findOrFail($id);
        File::delete(public_path('uploads/reviews/'.$review->image));
        $review -> delete();
        return back()->with('message', 'Review Deleted');
     }
}
