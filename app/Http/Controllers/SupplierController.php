<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Supplier::latest()->get();
        return view('admin.supplier.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' =>'required',
            'link' =>'nullable',
            'note' =>'nullable',
            'email' =>'nullable',
            'telephone' =>'nullable',
            'alamat' =>'nullable',
        ]);

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Data Supplier Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Supplier::findOrFail($id);

        return view('admin.supplier.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Supplier::findOrFail($id);

        return view('admin.supplier.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' =>'required',
            'link' =>'nullable',
            'note' =>'nullable',
            'email' =>'nullable',
            'telephone' =>'nullable',
            'alamat' =>'nullable',
        ]);

        Supplier::findOrFail($id)->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Data Supplier Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Data Supplier Berhasil Dihapus');
    }
}
