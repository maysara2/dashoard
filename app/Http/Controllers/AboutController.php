<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=User::select(

            'id',
            'name',
            'email',
            'phone',
            'address',
            'job',
            'degree',
            'birth_day',
            'image',
            'experience')->where('id',1)->first();
            return view('admin.about.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user=User::first();
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'degree' => 'required',
            'experience' => 'required',
            'birth_day' => 'required|date',
            'job' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $img_name = $user->image;
        if($request->hasFile('image')) {
            File::delete(public_path('uploads/users/'.$user->image));
            $img = $request->file('image');
            $img_name = rand().time().$img->getClientOriginalName();
            $img->move(public_path('uploads/users/'), $img_name);
        }
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'degree'=>$request->degree,
            'experience'=>$request->experience,
            'birth_day'=>$request->birth_day,
            'job'=>$request->job,
            'image'=>$img_name,
        ]);
        return redirect()->route('admin.about.index')->with('message','About My Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
