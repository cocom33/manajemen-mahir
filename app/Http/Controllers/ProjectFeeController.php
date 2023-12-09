<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Project;
use App\Models\Langsung;
use App\Models\TerminFee;
use App\Models\ProjectTeam;
use Illuminate\Http\Request;
use App\Models\KeuanganProject;
use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;

class ProjectFeeController extends Controller
{
    public function projectFee($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::where('project_id', $data['project']->id)->get();

        if ($data['project']->keuangan_project && $data['project']->keuangan_project->type == 'langsung') {
            $data['fee_langsung'] = Langsung::where('keuangan_project_id', $data['project']->keuangan_project->id)->get();
            $data['project_teams'] = ProjectTeam::whereNotIn('id', $data['fee_langsung']->pluck('project_team_id'))->where([['project_id', $data['project']->id], ['status', 1]])->get();
        }

        if ($data['project']->keuangan_project && $data['project']->keuangan_project->type == 'termin') {
            $data['termin'] = Termin::where('keuangan_project_id', $data['project']->keuangan_project->id)->get();
        }
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.fee.index', $data);
    }

    public function projectFeeStore(Request $request, $slug)
    {
        $data = $request->all();
        KeuanganProject::create($data);

        return redirect()->back()->with('success', 'berhasil membuat type pembayaran');
    }

    public function projectFeeLangsungStore(Request $request)
    {
        $langsung = Langsung::find($request->id);
        $fee = str_replace("Rp. ", "", $request->fee);
        $price = str_replace(".", "", $fee);

        if($langsung) {
            $langsung->update([
                'fee'   => $price,
            ]);
            return redirect()->back()->with('success', 'berhasil merubah fee');
        }

        $data = $request->validate([
            'keuangan_project_id' => 'required',
            'project_team_id' => 'required',
            'fee' => 'required',
        ]);
        $data['fee'] = $price;

        Langsung::create($data);
        return redirect()->back()->with('success', 'berhasil melakukan pembayaran');
    }

    public function projectTerminStore(Request $request)
    {
        $termin = Termin::find($request->id);

        if($termin) {
            $termin->update([
                'name' => $request->name,
            ]);
            return redirect()->back()->with('success', 'berhasil merubah nama termin');
        }

        $data = $request->validate([
            'keuangan_project_id' => 'required',
            'name' => 'required',
        ]);

        Termin::create($data);
        return redirect()->back()->with('success', 'berhasil menambahkan termin');
    }

    public function projectTerminDetail($slug, $termin)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['termin'] = Termin::where('slug', $termin)->first();
        $data['teams'] = ProjectTeam::whereNotIn('id', $data['termin']->termin_fee->pluck('project_team_id'))->where([['project_id', $data['project']->id], ['status', 1]])->get();
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.fee.termin-fee', $data);
    }

    public function projectTerminDetailStore(Request $request)
    {
        $terminfee = TerminFee::find($request->id);
        $fee = str_replace("Rp. ", "", $request->fee);
        $price = str_replace(".", "", $fee);

        if ($terminfee) {
            $terminfee->update([
                'fee' => $price,
            ]);

            return redirect()->back()->with('success', 'berhasil update fee team');
        }

        $data = $request->validate([
            'project_team_id' => 'required',
            'termin_id' => 'required',
            'fee' => 'required',
        ]);
        $data['fee'] = $price;

        TerminFee::create($data);
        return redirect()->back()->with('success', 'berhasil menambahkan fee kepada team');
    }
}