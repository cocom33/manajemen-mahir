<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['d'] = 'tes';
        $data['users'] = User::get();

        return view('admin.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['route'] = route('users.create');
        $data['model'] = null;

        return view('admin.users.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
        $data['password'] = bcrypt($request->password);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Berhasil Membuat User');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['model'] = User::find($id);

        return view('admin.users.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['model'] = User::find($id);
        $data['route'] = route('users.update', $data['model']->id);

        return view('admin.users.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable',
        ]);
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Berhasil Mengupdate User');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus User');
    }
}
