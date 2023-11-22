<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\KeuanganPerusahaan;
use App\Models\KeuanganProject;
use App\Models\Langsung;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectTeam;
use App\Models\ProjectType;
use App\Models\Team;
use App\Models\Termin;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\TerminFee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PorjectController extends Controller
{
    public function index()
    {
        $data['projects'] = Project::get();

        return view('admin.project.index', $data);
    }

    public function projectDetail($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();

        return view('admin.project.detail', $data);
    }

    public function form($slug = '')
    {
        $data['model'] = Project::where('slug', $slug)->first();
        if ($data['model'] == null) {
            $data['route'] = route('project.store');
        } else {
            $data['route'] = route('project.update', $slug);
        }
        $data['clients'] = Client::all();
        $data['projectType'] = ProjectType::all();

        return view('admin.project.form', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'client_id' => 'required',
            'project_type_id' => 'required',
            'status' => 'required',
            'description' => 'required',
            'start_date' => 'sometimes',
            'deadline_date' => 'sometimes',
            'harga_penawaran' => 'sometimes',
            'harga_deal' => 'sometimes',
            'status_server' => 'sometimes',
        ]);

        $model = Project::create($data);
        return redirect()->route('project.detail', $model->slug)->with('success', 'berhasil membuat project baru');
    }

    public function update(Request $request, $slug)
    {
        $model = Project::where('slug', $slug)->first();

        $data = $request->validate([
            'name' => 'required',
            'client_id' => 'required',
            'project_type_id' => 'required',
            'status' => 'required',
            'description' => 'required',
            'start_date' => 'sometimes',
            'deadline_date' => 'sometimes',
            'harga_penawaran' => 'sometimes',
            'harga_deal' => 'sometimes',
            'status_server' => 'sometimes',
        ]);

        $model->update($data);
        return redirect()->route('project.detail', $model->slug)->with('success', 'berhasil mengupdate project');
    }

    public function delete($slug)
    {
        $data = Project::where('slug', $slug)->first();
        $data->delete();

        return back()->with('success', 'berhasil menghapus data');
    }

    public function projectLampiran($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['lampiran'] = ProjectDocument::where('project_id', $data['project']->id)->get();

        // dd($data['lampiran']->name);

        return view('admin.project.lampiran.index', $data);
    }

    public function projectLampiranStore(Request $request, $slug)
    {
        $data = Project::where('slug', $slug)->first();

        $request->validate([
            'name' => 'required',
            'link' => 'required',
        ]);

        $dt = New ProjectDocument();
        $dt->project_id = $data->id;
        $dt->name = $request->name;
        $dt->link = $request->link;
        $dt->save();

        return back()->with('success', $request->name .' created successfully!');
    }

    public function projectLampiranEdit($slug, $id)
    {
        $project = Project::where('slug', $slug)->first();


        if (!$project) {
            abort(404);
        }

        $lampiran = ProjectDocument::where('project_id', $project->id)->get();

        $single = ProjectDocument::where('id', $id)->first();

        return view('admin.project.lampiran.edit', compact('project', 'lampiran', 'single'));
    }


    public function projectLampiranUpdate(Request $request, $slug, $id)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required',
        ]);

        $dt = ProjectDocument::where('id', $id)->first();
        $dt->name = $request->name;
        $dt->link = $request->link;
        $dt->update();

        return redirect()->route('project.lampiran', $slug)->with('success', 'Lampiran ' .  $request->name .' updated successfully!');
    }

    public function projectLampiranDestroy($slug, $id)
    {
        $data = ProjectDocument::where('id', $id)->first();
        $data->delete();

        return redirect()->route('project.lampiran', $slug)->with('error', 'Lampiran ' .  $data->name .' deleted successfully!');
    }


    public function projectTeam($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();

        return view('admin.project.team.index', $data);
    }

    public function projectInvoice($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['invoice'] = Invoice::where('project_id', $data['project']->id)->first();
        // dd($data['invoice']);

        return view('admin.project.invoice.index', $data);
    }

    public function projectInvoiceStore(Request $request, $slug)
    {
        $project = Project::where('slug', $slug)->first();
        $invoiceNumber = 'INV'.now()->format('Ymd'). mt_rand(100,999);

        $data = $request->validate([
            'type' => 'required',
        ]);

        $data['project_id'] = $project->id;
        $data['no_invoice'] = Invoice::generateInvoiceNumber();
        $model = Invoice::create($data);

        return redirect()->back()->with('success', 'Invoice created successfully');

    }

    public function getInvoices($slug, $id)
    {
        $data['project'] = Project::with('client')->where('slug', $slug)->first();
        $data['invoice'] = Invoice::where('id', $id)->first();

        // $tanggalMulai = $data['project']->start_date;
        // $tanggalBatas = $data['project']->deadline_date;
        $tanggalMulai = Carbon::createFromFormat('Y-m-d', $data['project']->start_date);
        $tanggalBatas = Carbon::createFromFormat('Y-m-d', $data['project']->deadline_date);

        $selisihHari = $tanggalMulai->diffInDays($tanggalBatas);
        $selisihMinggu = $tanggalMulai->diffInWeeks($tanggalBatas);
        $selisihBulan = $tanggalMulai->diffInMonths($tanggalBatas);

        $terbilang = \Riskihajar\Terbilang\Facades\Terbilang::make( $data['project']->harga_deal);

        $pdf = Pdf::loadView('admin.project.invoice.invoice', $data, compact('selisihHari', 'selisihMinggu', 'selisihBulan', 'terbilang'));
        return $pdf->stream();
    }

    public function projectFee($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['fee_type'] = KeuanganProject::where('project_id', $data['project']->id)->first();
        $data['project_teams'] = ProjectTeam::where('project_id', $data['project']->id)->get();

        if ($data['fee_type'] && $data['fee_type']->type == 'langsung') {
            $data['fee_langsung'] = Langsung::where('keuangan_project_id', $data['fee_type']->id)->get();
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
        $data['teams'] = ProjectTeam::whereNotIn('id', $data['termin']->termin_fee->pluck('project_team_id'))->where('project_id', $data['project']->id)->get();

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