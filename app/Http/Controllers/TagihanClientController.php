<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\KeuanganDetail;
use App\Models\KeuanganPerusahaan;
use App\Models\Supplier;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanClientController extends Controller
{
    public function form($tagihan = null)
    {
        $data['clients'] = Client::get();
        $data['suppliers'] = Supplier::get();

        $data['tagihan'] = $tagihan;
        $data['route'] = route('tagihan.store');
        if($tagihan) {
            $data['tagihan'] = Tagihan::find($tagihan);
            $data['route'] = route('tagihan.update', $tagihan);
        }

        return view('admin.tagihan.form', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required',
            'supplier_id' => 'nullable',
            'title' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'total' => 'required',
            'description' => 'required',
        ]);

        $harga_beli = str_replace("Rp. ", "", $request->harga_beli);
        $data['harga_beli'] = str_replace(".", "", $harga_beli);

        $harga_jual = str_replace("Rp. ", "", $request->harga_jual);
        $data['harga_jual'] = str_replace(".", "", $harga_jual);

        if ($request->lunas) {
            $data['is_lunas'] = 1;
        }

        $tagihan = Tagihan::create($data);

        if ($request->lunas) {
            $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
            if (!$query) {
                $query = KeuanganPerusahaan::create([
                    'tahun' => date('Y'),
                    'bulan' => date('m'),
                ]);
            }

            KeuanganDetail::create([
                'keuangan_perusahaan_id' => $query->id,
                'tagihan_id' => $tagihan->id,
                'description' => 'Tagihan ' . explode(" ", $tagihan->title)[0],
                'status' => 'pengeluaran',
                'tanggal' => date('d'),
                'total' => $tagihan->harga_beli,
            ]);

            KeuanganDetail::create([
                'keuangan_perusahaan_id' => $query->id,
                'tagihan_id' => $tagihan->id,
                'description' => 'Tagihan ' . explode(" ", $tagihan->title)[0],
                'status' => 'pemasukan',
                'tanggal' => date('d'),
                'total' => $tagihan->harga_jual,
            ]);
        }

        return redirect()->route('tagihan')->with('Berhasil membuat Tagihan');
    }

    public function show($id)
    {
        $data['tagihan'] = Tagihan::find($id);

        return view('admin.tagihan.detail', $data);
    }

    public function update(Request $request, $id)
    {
        $query = Tagihan::findOrFail($id);

        $data = $request->validate([
            'client_id' => 'required',
            'supplier_id' => 'nullable',
            'title' => 'required',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'total' => 'required',
            'description' => 'required',
        ]);

        $harga_beli = str_replace("Rp. ", "", $request->harga_beli);
        $data['harga_beli'] = str_replace(".", "", $harga_beli);

        $harga_jual = str_replace("Rp. ", "", $request->harga_jual);
        $data['harga_jual'] = str_replace(".", "", $harga_jual);

        $query->update($data);

        return redirect()->route('tagihan.show', $id)->with('Berhasil Merubah Tagihan');
    }

    public function delete($id)
    {
        $tagihan = Tagihan::find($id);

        $data = KeuanganDetail::where('tagihan_id', $tagihan->id)->get();
        if ($data) {
            foreach ($data as $value) {
                $value->delete();
            }
        }
        $tagihan->delete();

        return redirect()->route('tagihan')->with('success', 'Berhasil Menghapus Tagihan');
    }

    public function lunas($id)
    {
        $data = Tagihan::find($id);
        $data->update([
            'is_lunas' => 1,
        ]);

        $query = KeuanganPerusahaan::where([['tahun', date('Y')], ['bulan', date('m')]])->first();
        if (!$query) {
            $query = KeuanganPerusahaan::create([
                'tahun' => date('Y'),
                'bulan' => date('m'),
            ]);
        }

        KeuanganDetail::create([
            'keuangan_perusahaan_id' => $query->id,
            'tagihan_id' => $data->id,
            'description' => 'Tagihan ' . explode(" ", $data->title)[0],
            'status' => 'pengeluaran',
            'tanggal' => date('d'),
            'total' => $data->harga_beli,
        ]);

        KeuanganDetail::create([
            'keuangan_perusahaan_id' => $query->id,
            'tagihan_id' => $data->id,
            'description' => 'Tagihan ' . explode(" ", $data->title)[0],
            'status' => 'pemasukan',
            'tanggal' => date('d'),
            'total' => $data->harga_jual,
        ]);

        return redirect()->back()->with('success', 'berhasil Update Tagihan');
    }

    public function nonAktif($id)
    {
        $data = Tagihan::find($id);
        $data->update([
            'is_finish' => 1,
        ]);

        return redirect()->back()->with('success', 'berhasil Menonaktifkan Tagihan');
    }

    public function clone($id)
    {
        $data = Tagihan::find($id);
        $data->update([
            'is_finish' => 1,
        ]);

        $days = Carbon::create($data->date_start)->diff($data->date_end);
        $end = date('Y-m-d', strtotime('+'. $days->days .' day', strtotime($data->date_end)));

        $data = $data->toArray();

        $data['date_start'] = $data['date_end'];
        $data['date_end'] = $end;
        $data['is_lunas'] = 0;
        $data['is_finish'] = 0;
        unset($data['id']);

        $tagihan = Tagihan::create($data);

        return redirect()->route('tagihan.show', $tagihan->id)->with('success', 'Berhasil Clone Tagihan');
    }
}