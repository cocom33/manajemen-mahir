<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $perusahaan = Perusahaan::latest()->get();
    return view('admin.perusahaan.index', compact('perusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
    return view('admin.perusahaan.create'); 
    }

    public function store(Request $request)
    {
    $validateData = $request->validate([
        'nama_perusahaan' => 'required', 
        'alamat' => 'required',
    ]);

    Perusahaan::create($validateData);
    
    return redirect()->route('perusahaan.index')->with('success', $request->nama_perusahaan .' created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
    return view('admin.perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Perusahaan::where('id', $id)->first();
        return view('admin.perusahaan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name',
            'nama_perusahaan' => 'required',
            'alamat' => 'required'
        ]);

        $dt = Perusahaan::find($id);

        $dt->update($validate);

        return redirect()->route('perusahaan.index')->with('success',  'Perusahaan ' . $dt->nama_perusahaan .' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();

        session()->flash('message', 'Perusahaan deleted successfully.');

        return redirect()->back();
    }
}