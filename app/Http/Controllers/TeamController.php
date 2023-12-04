<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\Skill;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();
        return view('admin.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['skills'] = Skill::get();
        return view('admin.team.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validate = $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'status' => 'required',
            'skill' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        // $skill = $validate['skill'];
        $validate['skill'] = json_encode($request->skill);
        Team::create($validate);

        return redirect()->route('teams.index')->with('success', 'Team '. $request->name .' created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $skills = Skill::get();

        $teamSkillsId = json_decode($team->skill, true);

        $skill_team = Skill::find($teamSkillsId);

        $projectsTeams = ProjectTeam::where('team_id', $team->id)->get();

        $projectId = $projectsTeams->pluck('project_id')->toArray();

        $projects = Project::whereIn('id', $projectId)->get();

        if ($projects->isEmpty()) {
            return view('admin.team.show', compact('team', 'skill_team'))->with('projects', null);
        }

        return view('admin.team.show', compact('team', 'skill_team', 'projects'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $skills = Skill::get();

        return view('admin.team.edit', compact('team', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $team->update($request->all());
        return redirect()->back('teams.index')->with('success', 'Team '. $request->name .' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        session()->flash('message', 'Team deleted successfully.');

        return redirect()->back();
    }
}
