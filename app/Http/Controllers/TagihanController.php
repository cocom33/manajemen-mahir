<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Project;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function list()
    {
        $data['tagihan'] = Tagihan::get();

        return view('admin.tagihan.index', $data);
    }

    public function index($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.tagihan.index', $data);
    }

    public function store(Request $request, $slug)
    {
        $project = Project::where('slug', $slug)->first();

        $data = $request->validate([
            'title' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'total' => 'required|min:1',
            'date_start' => 'required',
            'date_end' => 'required',
            'description' => 'required',
        ]);

        if($project->status == 'penawaran' || $project->status == 'deal') {
            $data['is_with_project'] = 1;
        } else {
            $data['is_with_project'] = 0;
        }

        $harga_beli = str_replace("Rp. ", "", $request->harga_beli);
        $data['harga_beli'] = str_replace(".", "", $harga_beli);

        $harga_jual = str_replace("Rp. ", "", $request->harga_jual);
        $data['harga_jual'] = str_replace(".", "", $harga_jual);

        $data['project_id'] = $request->project_id;
        $data['is_active'] = 1;
        $data['is_lunas'] = 0;

        $query = Tagihan::create($data);

        // if($project->status == 'penawaran' || $project->status == 'deal') {
        //     Pengeluaran::create([
        //         'project_id' => $request->project_id,
        //         'tagihan_id' => $query->id,
        //         'title' => $query->title,
        //         'price' => $query->harga_beli,
        //         'description' => $query->description,
        //         'date' => $query->date_start,
        //     ]);
        // }

        return redirect()->route('project.tagihan', $slug)->with('success', 'Berhasil Membuat Tagihan');
    }

    public function update(Request $request, $slug)
    {
        $tagihan = Tagihan::where('id', $request->tagihan_id)->first();

        $data = $request->validate([
            'title' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'total' => 'required|min:1',
            'date_start' => 'required',
            'date_end' => 'required',
            'description' => 'required',
        ]);

        $harga_beli = str_replace("Rp. ", "", $request->harga_beli);
        $data['harga_beli'] = str_replace(".", "", $harga_beli);

        $harga_jual = str_replace("Rp. ", "", $request->harga_jual);
        $data['harga_jual'] = str_replace(".", "", $harga_jual);

        $tagihan->update($data);

        $pengeluaran = Pengeluaran::where('tagihan_id', $tagihan->id)->first();
        $pengeluaran->update([
            'title' => $tagihan->title,
            'price' => $tagihan->harga_beli,
            'description' => $tagihan->description,
            'date' => $tagihan->date_start,
        ]);

        return redirect()->route('project.tagihan', $slug)->with('success', 'Berhasil Merubah Tagihan');
    }

    public function detail($slug, $id)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['tagihan'] = Tagihan::find($id);
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.tagihan.detail', $data);
    }

    public function edit($slug, $id)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['tagihan'] = Tagihan::find($id);
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.tagihan.edit', $data);
    }

    public function delete(Request $request)
    {
        $data = Tagihan::find($request->id);
        $pengeluaran = Pengeluaran::where('tagihan_id', $data->id)->first();

        $pengeluaran->delete();
        $data->delete();

        return redirect()->back()->with('success', 'berhasil menghapus tagihan');
    }

    public function lunas(Request $request)
    {
        $data = Tagihan::find($request->tagihan_id);
        $data->update(['is_lunas' => 1]);

        if($data->project->status == 'penawaran' || $data->project->status == 'deal') {
            Pengeluaran::create([
                'tagihan_id' => $data->id,
                'project_id' => $data->project->id,
                'title' => $data->title,
                'price' => $data->harga_beli,
                'description' => $data->description,
                'date' => $data->date_start,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Melunaskan Tagihan');
    }

    public function clone(Request $request, $slug)
    {
        $data = Tagihan::find($request->tagihan_id);
        $data->update([
            'is_finish' => 1,
        ]);

        $days = Carbon::create($data->date_start)->diff($data->date_end);
        $end = date('Y-m-d', strtotime('+'. $days->days .' day', strtotime($data->date_end)));

        if($data->project->status == 'penawaran' || $data->project->status == 'deal') {
            $data['is_with_project'] = 1;
        } else {
            $data['is_with_project'] = 0;
        }
        $data = $data->toArray();

        $data['date_start'] = $data['date_end'];
        $data['date_end'] = $end;
        $data['is_lunas'] = 0;
        $data['is_finish'] = 0;
        unset($data['id']);

        Tagihan::create($data);

        return redirect()->route('project.tagihan', $slug)->with('success', 'Berhasil Merubah Status Tagihan');
    }

    public function nonAktif(Request $request)
    {
        $data = Tagihan::find($request->tagihan_id);
        $data->update(['is_active' => !$data->is_active]);

        return redirect()->back()->with('success', 'Berhasil Merubah Status Tagihan');
    }
}