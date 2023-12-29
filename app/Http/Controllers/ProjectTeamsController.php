<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\ProjectTeamFee;
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
        $data['team'] = Team::find($id);
        $data['project'] = Project::where('slug', $slug)->first();
        $data['detail'] = $this->gaji($data['project']);
        $data['show'] = ProjectTeam::where('team_id', $data['team']->id)->first();

        return view('admin.project.team.detail', $data);
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

        if($request->file('photo')) {
            $image = $request->file('photo');
            $imageName = 'bukti-pembayaran-' . $data->slug . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        $fee = str_replace("Rp. ", "", $request->fee);
        $gaji = str_replace(".", "", $fee);

        $feeteam = ProjectTeamFee::create([
            'project_team_id' => $data->id,
            'fee' => $gaji,
            'photo' => $imageName ?? '',
        ]);

        Pengeluaran::create([
            'project_id' => $request->project_id,
            'title' => 'fee ' . $data->team->name,
            'date' => date('Y-m-d'),
            'price' => $gaji,
            'project_team_fee_id' => $feeteam->id
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambah data!');

        // $data->update([
        //     'fee' => $request->fee,
        //     'tanggal_pembayaran' => $request->tanggal_pembayaran,
        //     'photo' => $imageName,
        // ]);
        // if ($request->hasFile('photo')) {
        //     if (!empty($oldFile) && file_exists(public_path('images/' . $oldFile))) {
        //         unlink(public_path('images/' . $oldFile));
        //     }



        //     return redirect()->back()->with('success', 'Berhasil update data dan upload gambar!');
        // } else {
        //     $data->update([
        //         'fee' => $request->fee,
        //         'tanggal_pembayaran' => $request->tanggal_pembayaran,
        //         'photo' => $request->photo,
        //     ]);

        // }
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

    public function deleteFee($id)
    {
        $query = ProjectTeamFee::find($id);

        $query2 = Pengeluaran::where('project_team_fee_id', $query->id)->first();

        $query->delete();
        if ($query2) {
            $query2->delete();
        }

        return redirect()->back()->with('success', 'Berhasil menghapus fee');
    }
}