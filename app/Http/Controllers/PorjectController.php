<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\ProjectType;
use App\Models\Team;
use Illuminate\Http\Request;

class PorjectController extends Controller
{
    public function index()
    {
        return view('admin.project.index');
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
        $data['lampiran'] = ProjectDocument::where('project_id', $data['project']->id)->first();

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

    public function projectLampiranUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required',
        ]);

        $dt = ProjectDocument::where('project_id', $id)->first();
        $dt->name = $request->name;
        $dt->link = $request->link;
        $dt->update();

        return back()->with('success', $request->name .' updated successfully!');
    }

    public function projectTeam($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();

        return view('admin.project.team.index', $data);
    }

    public function projectInvoice($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();

        return view('admin.project.invoice.index', $data);
    }

    public function projectFee($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();

        return view('admin.project.fee.index', $data);
    }
}
