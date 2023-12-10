<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tagihan;
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
        $data = $request->validate([
            'title' => 'required',
            'harga_awal' => 'required',
            'harga_asli' => 'required',
            'total' => 'required|min:1',
            'date_start' => 'required',
            'date' => 'required',
            'date_type' => 'required',
            'description' => 'required',
        ]);

        $harga_awal = str_replace("Rp. ", "", $request->harga_awal);
        $data['harga_awal'] = str_replace(".", "", $harga_awal);

        $harga_asli = str_replace("Rp. ", "", $request->harga_asli);
        $data['harga_asli'] = str_replace(".", "", $harga_asli);

        $data['project_id'] = $request->project_id;
        $data['is_active'] = 1;
        $data['is_lunas'] = 0;

        Tagihan::create($data);

        return redirect()->route('project.tagihan', $slug)->with('success', 'Berhasil Membuat Tagihan');
    }

    public function update(Request $request, $slug)
    {
        $tagihan = Tagihan::where('id', $request->tagihan_id)->first();

        $data = $request->validate([
            'title' => 'required',
            'harga_awal' => 'required',
            'harga_asli' => 'required',
            'total' => 'required|min:1',
            'date_start' => 'required',
            'date' => 'required',
            'date_type' => 'required',
            'description' => 'required',
        ]);

        $harga_awal = str_replace("Rp. ", "", $request->harga_awal);
        $data['harga_awal'] = str_replace(".", "", $harga_awal);

        $harga_asli = str_replace("Rp. ", "", $request->harga_asli);
        $data['harga_asli'] = str_replace(".", "", $harga_asli);

        $tagihan->update($data);
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
        $data->delete();

        return redirect()->back()->with('success', 'berhasil menghapus tagihan');
    }

    public function lunas(Request $request)
    {
        $data = Tagihan::find($request->tagihan_id);
        $data->update(['is_lunas' => 1]);

        return redirect()->back()->with('success', 'Berhasil Melunaskan Tagihan');
    }

    public function clone(Request $request, $slug)
    {
        $data = Tagihan::find($request->tagihan_id)->toArray();
        switch ($data['date_type']) {
            case 'year':
                $tempo = date('Y-m-d', strtotime('+'. $data['date'] .' year', strtotime($data['date_start'])));
                break;
            case 'month':
                $tempo = date('Y-m-d', strtotime('+'. $data['date'] .' month', strtotime($data['date_start'])));
                break;
            case 'week':
                $tempo = date('Y-m-d', strtotime('+'. $data['date'] .' week', strtotime($data['date_start'])));
                break;
            case 'day':
                $tempo = date('Y-m-d', strtotime('+'. $data['date'] .' day', strtotime($data['date_start'])));
                break;
        }
        $data['date_start'] = $tempo;
        $data['is_lunas'] = 0;
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