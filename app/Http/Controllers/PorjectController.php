<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceOther;
use App\Models\InvoiceSystem;
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

        $data['detail'] = $this->gaji($data['project']);

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
            'pajak' => 'sometimes',
            'type_pajak' => 'sometimes',
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
            'pajak' => 'sometimes',
            'type_pajak' => 'sometimes',
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

        $data['detail'] = $this->gaji($data['project']);

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

        $detail = $this->gaji($project);

        return view('admin.project.lampiran.edit', compact('project', 'lampiran', 'single', 'detail'));
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
        $data['projectTeams'] = ProjectTeam::where([['project_id', $data['project']->id], ['status', '1']])->get();
        $data['teams'] = Team::whereNotIn('id', $data['projectTeams']->pluck('team_id'))->get();
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.team.index', $data);

    }

    public function projectEditTeam(Request $request, $slug)
    {
        $data = ProjectTeam::find($request->id);
        $data->update(['fee' => $request->fee]);
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

    public function projectInvoice($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['invoice'] = Invoice::where('project_id', $data['project']->id)->first();
        $data['detail'] = $this->gaji($data['project']);

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

        if ($data['invoice']->type == 'system'){
            $data['invoiceDetails'] = InvoiceSystem::where('invoice_id', $data['invoice']->id)->get();
            $data['total'] = 0;
            foreach ($data['invoiceDetails'] as $item) {
                $data['total'] += $item['price'] * $item['total'];
            }
            $data['terbilang'] = \Riskihajar\Terbilang\Facades\Terbilang::make( $data['total']);
        } else {
            $data['invoiceOthers'] = InvoiceOther::where('invoice_id', $data['invoice']->id)->get();
            $data['total'] = 0;
            foreach ($data['invoiceOthers'] as $item) {
                $data['total'] += $item['price'] * $item['total'];
            }
            $data['terbilang'] = \Riskihajar\Terbilang\Facades\Terbilang::make( $data['total']);
        }

        $pdf = Pdf::loadView('admin.project.invoice.invoice', $data);
        return $pdf->stream('inovice-'. $data['invoice']->no_invoice.'.pdf');
    }
}