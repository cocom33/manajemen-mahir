<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('admin.client.index', $this->getMenuData(), compact('clients'));
    }

        public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $client = Client::create($request->all());
        return redirect()->route('client.index');
    }

    public function show(Client $client)
    {
        return view('admin.client.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        return redirect()->route('client.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('client.index');
    }

}