<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller 
{

  public function index()
  {
    $notes = Note::latest()->get();
    return view('admin.note.index', compact('notes'));
  }

  public function create() 
  {
    return view('admin.note.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => 'required',
      'content' => 'required'
    ]);

    if($request->hasFile('upload')) {
      $originName = $request->file('upload')->getClientOriginalName();
      $fileName = pathinfo($originName, PATHINFO_FILENAME);
      $extension = $request->file('upload')->getClientOriginalExtension();
      $fileName = $fileName.'_'.time().'.'.$extension;
      $request->file('upload')->move(public_path('images'), $fileName);
      $CKEditorFuncNum = $request->input('CKEditorFuncNum');
      $url = asset('images/'.$fileName); 
      $msg = 'Image successfully uploaded'; 
      $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
         
      @header('Content-type: text/html; charset=utf-8'); 
      echo $response;
  }

    $note = Note::create($validated);
    
    return redirect()
           ->route('note.index')
           ->with('success', 'Note created successfully!');

  }

  // NoteController

public function show(Note $note) 
{
  return view('admin.note.show', compact('note'));
}

  public function edit(Note $note)
  {
    return view('admin.note.edit', compact('note'));
  }

  public function update(Request $request, Note $note)
  {
    
    $validated = $request->validate([
      'title' => 'required',
      'content' => 'required'
    ]);

    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('public/notes');
      $validated['image'] = $path;
    }

    $note->update($validated);

    return redirect()
           ->route('note.index')
           ->with('success', 'Note updated successfully!');

  }

  public function destroy(Note $note)
  {
    $note->delete();

    return redirect()->route('note.index')
                    ->with('success', 'Note deleted successfully!'); 
  }

}