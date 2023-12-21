<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\Team;
use Illuminate\Http\Request;

class ProjectTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        $project = Project::where('slug', $slug)->first();
        $teams = Team::all();
        $detail = $this->gaji($project);
        
        return view('admin.project.team.index', compact('teams', 'detail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($slug)
    {
        $project = Project::where('slug', $slug)->first();
        $data['detail'] = $this->gaji($project);

        return view('admin.project.team.index');
    }

    /**
     * Store a newly created resource in storage.

     */
    public function store(Request $request)
{
    $projectTeam = new ProjectTeam;
    $projectTeam->project_id = $request->project_id;
    $projectTeam->team_id = $request->team_id;
    $projectTeam->save();

    return redirect()->back();
}


    /**
     * Display the specified resource.
     */
    public function show(string $slug, $id)
    {
        $team = Team::find($id);
        $project = Project::where('slug', $slug)->first();
        $detail = $this->gaji($project);

        
        
        return view('admin.project.team.detail', compact('team', 'project', 'detail'));
        
        
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = Team::find($id);
        $team->name = $request->name;
        $team->save();

        return redirect('/teams');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::find($id);
        $team->delete();

        return redirect('/teams');
    }
}