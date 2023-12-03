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

class ProjectFeeController extends Controller
{

    public function projectFee($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['fee_type'] = KeuanganProject::where('project_id', $data['project']->id)->first();

        if ($data['fee_type'] && $data['fee_type']->type == 'langsung') {
            $data['fee_langsung'] = Langsung::where('keuangan_project_id', $data['fee_type']->id)->get();
            $data['project_teams'] = ProjectTeam::whereNotIn('id', $data['fee_langsung']->pluck('project_team_id'))->where([['project_id', $data['project']->id], ['status', 1]])->get();
        }

        if ($data['fee_type'] && $data['fee_type']->type == 'termin') {
            $data['termin'] = Termin::where('keuangan_project_id', $data['fee_type']->id)->get();
        }

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

        if($langsung) {
            $langsung->update([
                'fee'   => $request->fee,
            ]);
            return redirect()->back()->with('success', 'berhasil merubah fee');
        }

        $data = $request->validate([
            'keuangan_project_id' => 'required',
            'project_team_id' => 'required',
            'fee' => 'required',
        ]);

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

        return view('admin.project.fee.termin-fee', $data);
    }

    public function projectTerminDetailStore(Request $request)
    {
        $terminfee = TerminFee::find($request->id);

        if ($terminfee) {
            $terminfee->update([
                'fee' => $request->fee,
            ]);

            return redirect()->back()->with('success', 'berhasil update fee team');
        }

        $data = $request->validate([
            'project_team_id' => 'required',
            'termin_id' => 'required',
            'fee' => 'required',
        ]);

        TerminFee::create($data);
        return redirect()->back()->with('success', 'berhasil menambahkan fee kepada team');
    }
}