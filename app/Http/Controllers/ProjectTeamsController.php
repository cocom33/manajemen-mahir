<?php

namespace App\Http\Controllers;

use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use App\Models\Pengeluaran;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\ProjectTeamFee;
use App\Models\Team;
use App\Models\Bank;
use Illuminate\Http\Request;

class ProjectTeamsController extends Controller
{

    public function projectTeam($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['projectTeams'] = ProjectTeam::where([['project_id', $data['project']->id], ['status', '1']])->get();
        $data['teams'] = Team::whereNotIn('id', $data['projectTeams']->pluck('team_id'))->get();
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.team.index', $data);

    }

    public function projectEditTeam(Request $request, $slug)
    {
        $fee = str_replace("Rp. ", "", $request->fee);
        $price = str_replace(".", "", $fee);

        $data = ProjectTeam::find($request->id);
        $data->update(['fee' => $price]);
        return redirect()->back()->with('success', 'berhasil merubah fee team');
    }

    public function projectAddTeam(Request $request, $slug)
    {
        $project = Project::where('slug', $slug)->first();
        $request->validate([
            'team_id' => 'required'
        ]);


        foreach ($request->team_id as $key => $value) {
            $data = ProjectTeam::where([['team_id', $value], ['project_id', $project->id]])->first();
            if($data) {
                $data->update(['status' => 1]);
            } else {
                ProjectTeam::create([
                    'project_id' => $project->id,
                    'team_id' => $value,
                ]);
            }
        }

        return redirect()->back()->with('success', 'berhasil menambahkan tim');
    }

    public function projectDeleteTeam($slug, $id)
    {
        $data = ProjectTeam::find($id);
        $data->update(['status' => 0]);

        return redirect()->back()->with('success', 'berhasil menghapus tim');
    }

    public function projectTeamLunas(Request $request, $slug, $id)
    {
        if($request->file('photo')) {
            $image = $request->file('photo');
            $imageName = 'bukti-pembayaran-' . $slug . '-'. date('d-m-Y') . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        $data = ProjectTeamFee::find($id);
        $data->update([
            'status' => 1,
            'photo' => $imageName ?? '',
        ]);

        $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
        if (!$query) {
            $query = KeuanganPerusahaan::create([
                'tahun' => date('Y'),
                'bulan' => date('m'),
            ]);
        }

        KeuanganDetail::create([
            'keuangan_perusahaan_id' => $query->id,
            'project_team_fee_id' => $data->id,
            'description' => 'fee ' . $data->projectTeam->team->name,
            'status' => 'pengeluaran',
            'tanggal' => date('d'),
            'total' => $data->fee,
        ]);

        Pengeluaran::create([
            'project_id' => $request->project_id,
            'title' => 'fee ' . $data->projectTeam->team->name,
            'date' => date('Y-m-d'),
            'price' => $data->fee,
            'project_team_fee_id' => $data->id
        ]);

        return redirect()->back()->with('success', 'berhasil melunasi fee team');
    }

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
        // $team = Team::find()
        dd($request->all());
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
        $data['team'] = ProjectTeam::find($id);
        $data['project'] = Project::where('slug', $slug)->first();
        $data['detail'] = $this->gaji($data['project']);
        $data['fee'] = $data['team']->project_team_fee;
        $data['banks'] = Bank::get();

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
        // dd($request);
        $data = ProjectTeam::find($request->team_id);
        $team = Team::find($request->detail_team_id);

        // dd($team);

        if($request->file('photo')) {
            $image = $request->file('photo');
            $imageName = 'bukti-pembayaran-' . $data->slug . '-'. date('d-m-Y') . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        $fee = str_replace("Rp. ", "", $request->fee);
        $gaji = str_replace(".", "", $fee);
        $status = 0;
        if ($request->lunas) {
            $status = 1;
        }

        if($request->has('nasabah_team')){
            $feeteam = ProjectTeamFee::create([
                'project_team_id' => $data->id,
                'fee' => $gaji,
                'status' => $status,
                'tenggat' => $request->tenggat,
                'nasabah_team' => $request->nasabah_team,
                'nasabah_kantor' => $request->nasabah_kantor,
                'photo' => $imageName ?? '',

            ]);
        } else {
            $feeteam = ProjectTeamFee::create([
                'project_team_id' => $data->id,
                'fee' => $gaji,
                'status' => $status,
                'tenggat' => $request->tenggat,
                'nasabah_team' => $team->nasabah_team->projectTeam->nasabah,
                'nasabah_kantor' => $request->nasabah_kantor,
                'photo' => $imageName ?? '',
            ]);
        }



        if ($request->lunas) {
            $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
            if (!$query) {
                $query = KeuanganPerusahaan::create([
                    'tahun' => date('Y'),
                    'bulan' => date('m'),
                ]);
            }

            KeuanganDetail::create([
                'keuangan_perusahaan_id' => $query->id,
                'project_team_fee_id' => $feeteam->id,
                'description' => 'fee ' . $data->team->name,
                'status' => 'pengeluaran',
                'tanggal' => date('d'),
                'total' => $gaji,
            ]);

            Pengeluaran::create([
                'project_id' => $request->project_id,
                'title' => 'fee ' . $data->team->name,
                'date' => date('Y-m-d'),
                'price' => $gaji,
                'project_team_fee_id' => $feeteam->id
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Menambah data!');
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
        $query3 = KeuanganDetail::where('project_team_fee_id', $query->id)->first();

        $query->delete();
        if ($query2) {
            $query2->delete();
        }
        if ($query3) {
            $query3->delete();
        }

        return redirect()->back()->with('success', 'Berhasil menghapus fee');
    }
}
