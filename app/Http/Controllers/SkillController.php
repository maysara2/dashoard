<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $skills = Skill::all();
        // return view('admin.skill.index', compact('skills'));

        $skills =Skill::all();
        return view('admin.skill.index',compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gg=  $request->validate([
             'name' => 'required|min:3',
             'color' => 'required|min:7',
            'percent' => 'required|numeric|gt:0|lte:100',
         ]);
         Skill::create($gg);
         return to_route('admin.skill.index')->with('message','New skill Added');

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
    public function edit(Skill $skill)
    {
         return view('admin.skill.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'color' => 'required|min:7',
            'percent' => 'required|numeric|gt:0|lte:100',
        ]);
        $skill-> update($validated);
        return to_route('admin.skill.index')->with('message', 'Skill Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill -> delete();
        return back()->with('message', 'Skill Deleted');
    }
}
