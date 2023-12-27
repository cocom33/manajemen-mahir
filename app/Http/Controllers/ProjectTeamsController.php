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
    // dd($request->project_id);
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
        // dd($team->id);
        $project = Project::where('slug', $slug)->first();
        $detail = $this->gaji($project);
        $show = ProjectTeam::where('team_id', $team->id)->first();
        // dd($show);

        
        return view('admin.project.team.detail', compact('team', 'project', 'detail','show'));
        
        
        
        
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
        
        $data = ProjectTeam::find($request->team_id);
        if ($request->hasFile('photo')) {
            if (!empty($oldFile) && file_exists(public_path('images/' . $oldFile))) {
                unlink(public_path('images/' . $oldFile));
            }

            $image = $request->file('photo');
            $imageName = 'bukti-pembayaran-' . $data->slug . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            $data->update([
                'fee' => $request->fee,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'photo' => $imageName,
            ]);

            return redirect()->back()->with('success', 'Berhasil update data dan upload gambar!');
        } else {
            $data->update([
                'fee' => $request->fee,
                'tanggal_pembayaran' => $request->tanggal_pembayaran,
                'photo' => $request->photo,
            ]);

            return redirect()->back()->with('success', 'Berhasil update data!');
        }
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