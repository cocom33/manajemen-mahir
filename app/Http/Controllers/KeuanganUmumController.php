<?php

namespace App\Http\Controllers;

use App\Models\KeuanganUmum;
use Illuminate\Http\Request;

class KeuanganUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = KeuanganUmum::all();
        return view('admin.keuangan-umum.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.keuangan-umum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'status' => 'required',
            'total' => 'required|integer',
        ]);

        $dt = New KeuanganUmum();
        $dt->description = $request->description;
        $dt->status = $request->status;
        $dt->total = $request->total;
        $dt->save();

        return redirect()->route('keuangan-umum.index')->with('success', 'Keuangan Umum created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = KeuanganUmum::where('id', $id)->first();
        return view('admin.keuangan-umum.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dt = KeuanganUmum::where('id', $id)->first();

        $request->validate([
            'description' => 'required',
            'status' => 'required',
            'total' => 'required|integer',
        ]);

        $dt->description = $request->description;
        $dt->status = $request->status;
        $dt->total = $request->total;
        $dt->update();

        return redirect()->route('keuangan-umum.index')->with('success', 'Keuangan Umum created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dt = KeuanganUmum::where('id', $id)->first();

        $dt->delete();

        return redirect()->back()->with('error', 'Keuangan Umum deleted!');
    }
}
