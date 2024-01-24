<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('project')->latest()->get();

        return view('admin.client.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        $dt = New Client();
        $dt->name = $request->name;
        $dt->wa = $request->wa;
        $dt->email = $request->email;
        $dt->alamat = $request->alamat;
        $dt->sumber = $request->sumber;
        $dt->save();

        return redirect()->route('client.index')->with('success', 'Client '. $dt->name .' created successfully!');
    }

    public function show(Client $client)
    {
        $projects = Project::where('client_id', $client->id)->get();

        return view('admin.client.show', compact('client', 'projects'));
    }

    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    public function update(Request $request, String $id)
    {
        $dt = Client::where('id', $id)->first();

        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        $dt->name = $request->name;
        $dt->wa = $request->wa;
        $dt->email = $request->email;
        $dt->alamat = $request->alamat;
        $dt->sumber = $request->sumber;
        $dt->update();

        return redirect()->route('client.index')->with('success', 'Client '. $dt->name .' updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('client.index')->with('error', 'Client '. $client->name .' deleted successfully!');
    }

}
