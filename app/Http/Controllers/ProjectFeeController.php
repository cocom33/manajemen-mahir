<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Project;
use App\Models\Langsung;
use App\Models\TerminFee;
use App\Models\ProjectTeam;
use Illuminate\Http\Request;
use App\Models\KeuanganProject;
use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProjectFeeController extends Controller
{
    public function projectFee($slug)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['pengeluaran'] = Pengeluaran::where('project_id', $data['project']->id)->get();

        if ($data['project']->keuangan_project && $data['project']->keuangan_project->type == 'langsung') {
            $data['fee_langsung'] = Langsung::where('keuangan_project_id', $data['project']->keuangan_project->id)->first();
            // $data['project_teams'] = ProjectTeam::whereNotIn('id', $data['fee_langsung']->pluck('project_team_id'))->where([['project_id', $data['project']->id], ['status', 1]])->get();
        }

        if ($data['project']->keuangan_project && $data['project']->keuangan_project->type == 'termin') {
            $data['termin'] = Termin::where('keuangan_project_id', $data['project']->keuangan_project->id)->get();
        }
        $data['detail'] = $this->gaji($data['project']);

        // dd($data['fee_langsung']);

        return view('admin.project.fee.index', $data);
    }

    public function projectFeeStore(Request $request, $slug)
    {
        $data = $request->all();
        KeuanganProject::create($data);

        return redirect()->back()->with('success', 'berhasil membuat type pembayaran');
    }

    public function projectFeeLangsungStore(Request $request)
    {
        $fee = str_replace("Rp. ", "", $request->price);
        $price = str_replace(".", "", $fee);

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $imageName = 'bukti-pembayaran-langsung-project-' . $request->slug . '.' . $image->extension();
            $image->move(public_path('bukti-pembayaran'), $imageName);

            $data = $request->validate([
                'keuangan_project_id' => 'required',
                'name' => 'required',
                'price' => 'required',
                'tanggal' => 'required',
            ]);

            $data['price'] = $price;
            $data['status'] = 1;
            $data['lampiran'] = $imageName;

            Langsung::create($data);
            return redirect()->back()->with('success', 'Berhasil membuat data dan upload bukti pembayaran!');
        } else {
            $data = $request->validate([
                'keuangan_project_id' => 'required',
                'name' => 'required',
                'price' => 'required',
                'tanggal' => 'required',
            ]);

            $data['price'] = $price;

            Langsung::create($data);
            return redirect()->back()->with('success', 'Berhasil membuat data!');
        }

    }

    public function projectFeeLangsungUpdate(Request $request)
    {
        $langsung = Langsung::find($request->id);
        $fee = str_replace("Rp. ", "", $request->price);
        $price = str_replace(".", "", $fee);

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $imageName = 'bukti-pembayaran-' . $langsung->slug . '.' . $image->extension();
            $image->move(public_path('bukti-pembayaran'), $imageName);

            $langsung->update([
                'name' => $request->name,
                'price' => $price,
                'tanggal' => $request->tanggal,
                'status' => 1,
                'lampiran' => $imageName,
            ]);

            return redirect()->back()->with('success', 'Berhasil update data dan upload gambar!');
        } else {
            $langsung->update([
                'name' => $request->name,
                'price' => $price,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()->back()->with('success', 'Berhasil update data!');
        }
    }

    public function deleteLampiranLangsung($slug, $id)
    {
        $langsung = Langsung::find($id);

        if ($langsung->lampiran) {
            unlink(public_path('bukti-pembayaran/' . $langsung->lampiran));
            Storage::delete('bukti-pembayaran/' . $langsung->lampiran);
        }

        $langsung->update(['status' => 0, 'lampiran' => null]);

        return redirect()->back()->with('success', 'Berhasil menghapus file.');
    }

    public function projectTerminStore(Request $request)
    {
        // $termin = Termin::find($request->id);
        $fee = str_replace("Rp. ", "", $request->price);
        $price = str_replace(".", "", $fee);

        // if($termin) {
        //     $termin->update([
        //         'name' => $request->name,
        //         'price' => $price,
        //         'tanggal' => $request->tanggal,
        //     ]);
        //     return redirect()->back()->with('success', 'berhasil merubah nama termin');
        // }


        $data = $request->validate([
            'keuangan_project_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'tanggal' => 'required',
        ]);

        $data['price'] = $price;
        Termin::create($data);
        return redirect()->back()->with('success', 'berhasil menambahkan termin');
    }

    public function projectTerminDetail($slug, $termin)
    {
        $data['project'] = Project::where('slug', $slug)->first();
        $data['termin'] = Termin::where('slug', $termin)->first();
        $data['teams'] = ProjectTeam::whereNotIn('id', $data['termin']->termin_fee->pluck('project_team_id'))->where([['project_id', $data['project']->id], ['status', 1]])->get();
        $data['detail'] = $this->gaji($data['project']);

        return view('admin.project.fee.termin-fee', $data);
    }

    public function projectTerminDetailStore($slug, Request $request)
    {
        // $terminfee = TerminFee::find($request->id);
        // $fee = str_replace("Rp. ", "", $request->fee);
        // $price = str_replace(".", "", $fee);

        // if ($terminfee) {
        //     $terminfee->update([
        //         'fee' => $price,
        //     ]);

        //     return redirect()->back()->with('success', 'berhasil update fee team');
        // }

        // $data = $request->validate([
        //     'project_team_id' => 'required',
        //     'termin_id' => 'required',
        //     'fee' => 'required',
        // ]);
        // $data['fee'] = $price;

        // TerminFee::create($data);
        // return redirect()->back()->with('success', 'berhasil menambahkan fee kepada team');

        $project = Project::where('slug', $slug)->first();
        $termin = Termin::find($request->id);
        $fee = str_replace("Rp. ", "", $request->price);
        $price = str_replace(".", "", $fee);
        // $price = str_replace(, "", $fee);

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $imageName = 'bukti-pembayaran-' . $project->slug . '-' . $termin->slug . '.' . $image->extension();
            $image->move(public_path('bukti-pembayaran'), $imageName);

            $termin->update([
                'name' => $request->name,
                'price' => $price,
                'tanggal' => $request->tanggal,
                'status' => 1,
                'lampiran' => $imageName,
            ]);

            return redirect()->back()->with('success', 'Berhasil update data dan upload gambar!');
        } else {
            $termin->update([
                'name' => $request->name,
                'price' => $price,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()->back()->with('success', 'Berhasil update data!');
        }
    }

    public function deleteLampiranTermin($id)
    {
        $termin = Termin::find($id);

        if ($termin->lampiran) {
            unlink(public_path('bukti-pembayaran/' . $termin->lampiran));
            Storage::delete('bukti-pembayaran/' . $termin->lampiran);
        }

        $termin->update(['status' => 0, 'lampiran' => null]);

        return redirect()->back()->with('success', 'Berhasil menghapus file.');
    }

    public function deleteTipePembayaran($slug, $id) {
        $keuanganProjects = KeuanganProject::where('id', $id)->first();

        if ($keuanganProjects->type == 'termin') {
            $termins = Termin::where('keuangan_project_id', $keuanganProjects->id)->get();
            foreach ($termins as $termin) {
                if ($termin->lampiran) {
                    unlink(public_path('bukti-pembayaran/' . $termin->lampiran));
                    Storage::delete('bukti-pembayaran/' . $termin->lampiran);
                }
                $termin->forceDelete();
            }
        } else {
            $langsung = Langsung::where('keuangan_project_id', $keuanganProjects->id)->first();

            if ($langsung != null ){
                if ($langsung->lampiran) {
                    unlink(public_path('bukti-pembayaran/' . $langsung->lampiran));
                    Storage::delete('bukti-pembayaran/' . $langsung->lampiran);
                    $langsung->forceDelete();
                } else {
                    $langsung->forceDelete();
                }
            }
        }

        $keuanganProjects->forceDelete();
        return redirect()->back()->with('success', 'Berhasil menghapus tipe pembayaran.');
    }
}
