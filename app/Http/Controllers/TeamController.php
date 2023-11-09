<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();
        return view('admin.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'wa' => 'required',
            'status' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        $dt = New Team();
        $dt->name = $request->name;
        $dt->wa = $request->wa;
        $dt->email = $request->email;
        $dt->alamat = $request->alamat;
        $dt->status = $request->status;
        $dt->save();

        return redirect()->route('teams.index')->with('success', 'Team '. $dt->name .' created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('admin.team.show', compact('teams'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $team->update($request->all());
        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        session()->flash('message', 'Team deleted successfully.');

        return redirect()->back();
    }
}
