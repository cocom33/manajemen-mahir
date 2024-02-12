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
        $data['projects'] = Project::orderBy('id', 'desc')->get();

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

        if($request->type_pajak == 2) {
            $data['pajak'] = null;
            $data['type_pajak'] = null;
        } else {
            $data['pajak'] = str_replace("%", "", $request->pajak);

            if($request->pajak > 100) {
                return back()->with('error', 'Pajak tidak boleh lebih dari 100%');
            }
        }

        if($request->harga_penawaran) {
            $harga_penawaran = str_replace("Rp. ", "", $request->harga_penawaran);
            $data['harga_penawaran'] = str_replace(".", "", $harga_penawaran);
        }

        if($request->harga_deal) {
            $harga_deal = str_replace("Rp. ", "", $request->harga_deal);
            $data['harga_deal'] = str_replace(".", "", $harga_deal);
        }

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

        if($request->type_pajak == 2) {
            $data['pajak'] = null;
            $data['type_pajak'] = null;
        } else {
            $data['pajak'] = str_replace("%", "", $request->pajak);

            if($request->pajak > 100) {
                return back()->with('error', 'Pajak tidak boleh lebih dari 100%');
            }
        }

        if($request->harga_penawaran) {
            $harga_penawaran = str_replace("Rp. ", "", $request->harga_penawaran);
            $data['harga_penawaran'] = str_replace(".", "", $harga_penawaran);
        }

        if($request->harga_deal) {
            $harga_deal = str_replace("Rp. ", "", $request->harga_deal);
            $data['harga_deal'] = str_replace(".", "", $harga_deal);
        }

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
        $data['lampiran'] = ProjectDocument::where('project_id', $data['project']->id)->orderBy('id', 'desc')->get();

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
}