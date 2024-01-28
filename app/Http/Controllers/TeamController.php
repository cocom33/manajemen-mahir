<?php

namespace App\Http\Controllers;

use App\Models\PorjectTeamFee;
use App\Models\Project;
use App\Models\ProjectFee;
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
        $teams = Team::orderBy('id', 'desc')->get();
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
            'nasabah' => 'nullable',
            'no_rekening' => 'nullable',
            'nama_rekening' => 'nullable',
            // 'foto_ktp' => 'image|mimes:jpeg,png|max:2048', 
            // 'pas_foto' => 'image|mimes:jpeg,png|max:2048',
            // 'cv' => 'mimes:pdf|max:2048'
            'cv' => 'mimes:pdf|max:2048',
        ]);
        // Upload Foto KTP
        if($request->hasFile('foto_ktp')) {

            $image = $request->file('foto_ktp');
        
            $fileName = 'foto_ktp_' . time() . '.' . $image->extension();  
        
            $folder = public_path('foto_ktp');
        
            $image->move($folder, $fileName);
        
            $validate['foto_ktp'] = $fileName;
        
        }
        
        // Upload Pas Foto 
        if($request->hasFile('pas_foto')) {
        
            $image = $request->file('pas_foto');
            
            $fileName = 'pas_foto_' . time() . '.' . $image->extension();
        
            $folder = public_path('pas_foto');
            
            $image->move($folder, $fileName);
        
            $validate['pas_foto'] = $fileName;
        
        }
        
        // Upload CV
        if($request->hasFile('cv')) {
        
            $file = $request->file('cv');
        
            $fileName = 'cv_' . time() . '.' . $file->extension();
        
            $folder = public_path('cv');
        
            $file->move($folder, $fileName);
        
            $validate['cv'] = $fileName; 
        
        }
        
        // Simpan data
  
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

        $projects = Project::with('projectTeams')->whereIn('id', $projectId)->get();

        // $projectsTeamFees = PorjectTeamFee::get();

        // dd($projectsTeamFees);

        if ($projects->isEmpty()) {
            return view('admin.team.show', compact('team', 'skill_team'))->with('projects', null);
        }

        return view('admin.team.show', compact('team', 'skill_team', 'projects', 'projectsTeams'));
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

      $validated = $request->validate([
        'name' => 'required',
        'wa' => 'required',
        'status' => 'required',
        'skill' => 'required',
        'email' => 'required',
        'alamat' => 'required',
      ]);

      // Foto KTP
      if($request->hasFile('foto_ktp')) {

        $image = $request->file('foto_ktp');
        $fileName = 'foto_ktp_' . time() . '.' . $image->extension();
        $folder = public_path('foto_ktp');
        $image->move($folder, $fileName);

        $validated['foto_ktp'] = $fileName;

      } else if($request->old_foto_ktp) {

        $validated['foto_ktp'] = $request->old_foto_ktp;
      
      }

      // Pas Foto
      if($request->hasFile('pas_foto')) {

        $image = $request->file('pas_foto');
        $fileName = 'pas_foto_' . time() . '.' . $image->extension();
        $folder = public_path('pas_foto');
        $image->move($folder, $fileName);

        $validated['pas_foto'] = $fileName;

      } else if($request->old_pas_foto) {

        $validated['pas_foto'] = $request->old_pas_foto;
      
      }

      // CV
      if($request->hasFile('cv')) {

        $file = $request->file('cv');
        $fileName = 'cv_' . time() . '.' . $file->extension();
        $folder = public_path('cv');
        $file->move($folder, $fileName);

        $validated['cv'] = $fileName;

      } else if($request->old_cv) {

        $validated['cv'] = $request->old_cv;
      
      }

      $team->update($validated);

      return redirect()->route('teams.index')->with('success', 'Team '. $request->name .' created successfully!');


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