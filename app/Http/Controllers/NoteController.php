<?php

namespace App\Http\Controllers;

use App\Models\Note;
use DOMDocument;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

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
      // dd($request);
        $description = $request->description;

        $dom = new DOMDocument();
        $dom->loadHTML($description,9);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $data = base64_decode(explode(',',explode(';',$img->getAttribute('src'))[1])[1]);
            $image_name = "/upload-notes/" . time(). $key.'.png';
            file_put_contents(public_path().$image_name,$data);

            $img->removeAttribute('src');
            $img->setAttribute('src',$image_name);
        }
        $description = $dom->saveHTML();

        Note::create([
            'title' => $request->title,
            'description' => $description
        ]);

        return redirect()->route('notes.index')->with('success', 'Success notes added');
    }
  // NoteController

public function show(Note $note)
{
  return view('admin.note.show', compact('note'));
}

public function edit($id)
{
  $note = Note::find($id);
  return view('admin.note.edit', compact('note'));
}

public function update(Request $request, $id)
    {
        $note = Note::find($id);

        $description = $request->description;

        $dom = new DOMDocument();
        $dom->loadHTML($description,9);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {

            // Check if the image is a new one
            if (strpos($img->getAttribute('src'),'data:image/') ===0) {

                $data = base64_decode(explode(',',explode(';',$img->getAttribute('src'))[1])[1]);
                $image_name = "/upload-notes/" . time(). $key.'.png';
                file_put_contents(public_path().$image_name,$data);

                $img->removeAttribute('src');
                $img->setAttribute('src',$image_name);
            }

        }
        $description = $dom->saveHTML();

        $note->update([
            'title' => $request->title,
            'description' => $description
        ]);

        return redirect()->route('notes.index')->with('success', 'Notes edited successfully');


    }

    public function destroy($id)
    {
        $note = Note::find($id);

        $dom= new DOMDocument();
        $dom->loadHTML($note->description,9);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {

            $src = $img->getAttribute('src');
            $path = Str::of($src)->after('/');


            if (File::exists($path)) {
                File::delete($path);

            }
        }

        $note->delete();
        return redirect()->back();

    }

  public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}
