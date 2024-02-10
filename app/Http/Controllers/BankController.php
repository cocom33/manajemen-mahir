<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Bank::latest()->get();
        return view('admin.bank.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'rekening' =>'nullable',
            'note' =>'nullable',
        ]);

        Bank::create($request->all());

        return redirect()->route('banks.index')->with('success', 'Data Bank Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Bank::findOrFail($id);

        return view('admin.bank.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Bank::findOrFail($id);

        return view('admin.bank.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' =>'required',
            'rekening' =>'required',
            'note' =>'nullable',
        ]);

        Bank::findOrFail($id)->update($request->all());

        return redirect()->route('banks.index')->with('success', 'Data Bank Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bank = Bank::findOrFail($id);
        if($bank->keuanganDetail->count() >= 1) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus bank, bank sudah memiliki riwayat');
        }

        $bank->delete();

        return redirect()->route('banks.index')->with('success', 'Data Bank Berhasil Dihapus');
    }
}