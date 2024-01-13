<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Project;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::where('project_id', $data['project']->id)->latest()->get();

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.pengeluaran.index', $data);
    }

    public function laporan($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::where('project_id', $data['project']->id)->latest()->get();

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.laporan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required',
            'title' => 'required',
            'date' => 'required',
            'price' => 'required',
            'description' => 'nullable',
        ]);
        $price = str_replace("Rp. ", "", $request->price);
        $data['price'] = str_replace(".", "", $price);

        Pengeluaran::create($data);
        return redirect()->back()->with('success', 'Berhasil Menambahkan Pengeluaran Project');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug, $id)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::find($id);

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.pengeluaran.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug, $id)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::find($id);

        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.pengeluaran.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug, $id)
    {
        $query = Pengeluaran::find($id);

        $data = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'price' => 'required',
            'description' => 'nullable',
        ]);
        $price = str_replace("Rp. ", "", $request->price);
        $data['price'] = str_replace(".", "", $price);

        $query->update($data);
        return redirect()->route('project.pengeluaran', $slug)->with('success', 'Berhasil Merubah Pengeluaran Project');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($slug, $id)
    {
        $query = Pengeluaran::find($id);
        $query->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Pengeluaran Project');
    }
}