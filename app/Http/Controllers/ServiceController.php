<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $services = Service::all();
         return view('admin.service.index', compact('services'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required',
            'name' => 'required|min:7',
            'description' => 'required|max:255',
        ]);
        Service::create($validated);
        return to_route('admin.servies.index')->with('message','New Service Added');

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
        $service=Service::find($id);

        return view('admin.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'icon' => 'required',
            'name' => 'required|min:7',
            'description' => 'required|max:255',
        ]);
        $service=Service::findOrFail($id);

        $service->update([
            'icon'=>$request->icon,
            'name'=>$request->name,
            'description'=>$request->description,
        ]);

        return redirect()->route('admin.servies.index')->with('message', 'Service Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       Service::destroy($id);
        return back()->with('message','Service Deleted');
    }
}
