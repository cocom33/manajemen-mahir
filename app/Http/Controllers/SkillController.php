<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Team;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Skill::all();
        return view('admin.skill.index', compact('datas'));
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
        $validate = $request->validate([
            'name' => 'required'
        ]);

        Skill::create($validate);

        return redirect()->route('skill.index')->with('success', $request->name .' created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {

        $teams = Team::all();

        // Decode the JSON string containing the skill IDs from $skill
        $skillIds = json_decode($skill->id, true);

        // Filter teams where the 'skill' column contains any of the skill IDs
        $team = $teams->filter(function ($team) use ($skillIds) {
            return collect($skillIds)->intersect(json_decode($team->skill, true))->isNotEmpty();
        });

        return view('admin.skill.show', compact('skill', 'team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Skill::where('id', $id)->first();
        return view('admin.skill.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);

        $dt = Skill::find($id);

        $dt->update($validate);

        return redirect()->route('skill.index')->with('success',  $dt->name .' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dt = Skill::where('id', $id)->first();

        $dt->delete();

        return redirect()->route('skill.index')->with('error', $dt->name .' deleted successfully!');
    }
}
