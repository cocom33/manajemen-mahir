<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Project;
use App\Models\Langsung;
use App\Models\ProjectTeam;
use Illuminate\Http\Request;
use App\Models\KeuanganProject;
use App\Http\Controllers\Controller;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
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
            $data['termin'] = Termin::where('keuangan_project_id', $data['project']->keuangan_project->id)->orderBy('id', 'desc')->get();
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
            $imageName = 'bukti-pembayaran-langsung-project-' . $request->slug . '-'. date('d-m-Y') . '.' . $image->extension();
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
            $langsung = Langsung::create($data);

            $keuangan = KeuanganDetail::where('langsung_id', $langsung->id)->first();
            if (!$keuangan) {
                $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
                if (!$query) {
                    $query = KeuanganPerusahaan::create([
                        'tahun' => date('Y'),
                        'bulan' => date('m'),
                    ]);
                }

                KeuanganDetail::create([
                    'keuangan_perusahaan_id' => $query->id,
                    'langsung_id' => $langsung->id,
                    'description' => 'Pemasukan Project',
                    'status' => 'pemasukan',
                    'tanggal' => date('d'),
                    'total' => $price,
                ]);
            }

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
            $imageName = 'bukti-pembayaran-' . $langsung->slug . '-'. date('d-m-Y') . '.' . $image->extension();
            $image->move(public_path('bukti-pembayaran'), $imageName);

            $langsung->update([
                'name' => $request->name,
                'price' => $price,
                'tanggal' => $request->tanggal,
                'status' => 1,
                'lampiran' => $imageName,
            ]);

            $keuangan = KeuanganDetail::where('termin_id', $langsung->id)->first();
            if (!$keuangan) {
                $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
                if (!$query) {
                    $query = KeuanganPerusahaan::create([
                        'tahun' => date('Y'),
                        'bulan' => date('m'),
                    ]);
                }

                KeuanganDetail::create([
                    'keuangan_perusahaan_id' => $query->id,
                    'langsung_id' => $langsung->id,
                    'description' => 'Pemasukan Project',
                    'status' => 'pemasukan',
                    'tanggal' => date('d'),
                    'total' => $price,
                ]);
            }

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

    public function projectTerminStore(Request $request, $slug)
    {
        if ($request->type == 'harga') {
            $fee = str_replace("Rp. ", "", $request->harga);
            $price = str_replace(".", "", $fee);
        } else {
            $project = Project::where('slug', $slug)->first();
            $price = $project->harga_deal * $request->price / 100;
        }

        $data = $request->validate([
            'keuangan_project_id' => 'required',
            'name' => 'required',
            'price' => 'sometimes',
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
        $project = Project::where('slug', $slug)->first();
        $termin = Termin::find($request->id);
        $fee = str_replace("Rp. ", "", $request->price);
        $price = str_replace(".", "", $fee);

        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $imageName = 'bukti-pembayaran-' . $project->slug . '-' . $termin->slug . '-'. date('d-m-Y') . '.' . $image->extension();
            $image->move(public_path('bukti-pembayaran'), $imageName);

            $termin->update([
                'name' => $request->name,
                'price' => $price,
                'tanggal' => $request->tanggal,
                'status' => 1,
                'lampiran' => $imageName,
            ]);

            $keuangan = KeuanganDetail::where('termin_id', $termin->id)->first();
            if (!$keuangan) {
                $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
                if (!$query) {
                    $query = KeuanganPerusahaan::create([
                        'tahun' => date('Y'),
                        'bulan' => date('m'),
                    ]);
                }

                KeuanganDetail::create([
                    'keuangan_perusahaan_id' => $query->id,
                    'termin_id' => $termin->id,
                    'description' => 'Pemasukan Project',
                    'status' => 'pemasukan',
                    'tanggal' => date('d'),
                    'total' => $price,
                ]);
            }

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
                KeuanganDetail::where('termin_id', $termin->id)->first()->forceDelete();
            }
        } else {
            $langsung = Langsung::where('keuangan_project_id', $keuanganProjects->id)->first();

            if ($langsung != null ){
                if ($langsung->lampiran) {
                    unlink(public_path('bukti-pembayaran/' . $langsung->lampiran));
                    Storage::delete('bukti-pembayaran/' . $langsung->lampiran);
                    $langsung->forceDelete();
                    KeuanganDetail::where('langsung_id', $langsung->id)->first()->forceDelete();
                } else {
                    $langsung->forceDelete();
                    KeuanganDetail::where('langsung_id', $langsung->id)->first()->forceDelete();
                }
            }
        }

        $keuanganProjects->forceDelete();
        return redirect()->back()->with('success', 'Berhasil menghapus tipe pembayaran.');
    }
}