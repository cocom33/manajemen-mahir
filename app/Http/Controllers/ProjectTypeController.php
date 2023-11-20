<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = ProjectType::all();
        return view('admin.project-type.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.project-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);

        ProjectType::create($validate);

        return redirect()->route('category-project.index')->with('success', $request->name .' created successfully!');
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
        $data = ProjectType::where('id', $id)->first();
        return view('admin.project-type.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);

        $dt = ProjectType::find($id);

        $dt->update($validate);

        return redirect()->route('category-project.index')->with('success', 'Project Type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dt = ProjectType::where('id', $id)->first();

        $dt->delete();

        return redirect()->route('category-project.index')->with('error', 'Project Type deleted successfully!');
    }
}
