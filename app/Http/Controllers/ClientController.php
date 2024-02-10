<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Perusahaan;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('id', 'desc')->get();
        return view('admin.client.index', compact('clients'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::get();
        return view('admin.client.create', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nomor_rekening' => 'nullable',
            'nama_rekening' => 'nullable',
            'nasabah_bank' => 'nullable',
            'nama_perusahaan' => 'nullable',
        ]);

        $dt = New Client();
        $dt->name = $request->name;
        $dt->wa = $request->wa;
        $dt->email = $request->email;
        $dt->alamat = $request->alamat;
        $dt->sumber = $request->sumber;
        $dt->nomor_rekening = $request->nomor_rekening;
        $dt->nama_rekening = $request->nama_rekening;
        $dt->nasabah_bank = $request->nasabah_bank;
        $dt->nama_perusahaan = $request->nama_perusahaan;

        $dt->save();

        return redirect()->route('client.index')->with('success', 'Client '. $dt->name .' created successfully!');
    }

    public function show(Client $client)
    {
        $projects = Project::where('client_id', $client->id)->get();
        $clients = Perusahaan::get();

        $perusahaanClientId = json_decode($client->nama_perusahaan, true);

        $perusahaan_client = Perusahaan::find($perusahaanClientId);

        // dd($perusahaan_client);

        return view('admin.client.show', compact('client', 'projects', 'perusahaan_client'));
    }

    public function edit(Client $client)
    {
        $perusahaans = Perusahaan::all();
        return view('admin.client.edit', compact('client', 'perusahaans'));
    }

    public function update(Request $request, String $id)
    {
        $dt = Client::where('id', $id)->first();

        $nama_perusahaan = Perusahaan::get();

        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nomor_rekening' => 'nullable',
            'nama_rekening' => 'nullable',
            'nasabah_bank' => 'nullable',
            'nama_perusahaan' => 'nullable',
        ]);

        $dt->name = $request->name;
        $dt->wa = $request->wa;
        $dt->email = $request->email;
        $dt->alamat = $request->alamat;
        $dt->sumber = $request->sumber;
        $dt->nomor_rekening = $request->nomor_rekening;
        $dt->nama_rekening = $request->nama_rekening;
        $dt->nasabah_bank = $request->nasabah_bank;
        $dt->nama_perusahaan = $request->nama_perusahaan;
        $dt->update();

        return redirect()->route('client.index')->with('success', 'Client '. $dt->name .' updated successfully!');
    }

    public function destroy(Client $client)
    {
        if($client->project->count() >= 1 || $client->tagihan->count() >= 1) {
            return redirect()->back()->with('error', 'Client sedang memeliki tagihan atau project');
        }
        $client->delete();
        return redirect()->route('client.index')->with('error', 'Client '. $client->name .' deleted successfully!');
    }

}