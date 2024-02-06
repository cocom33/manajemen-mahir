<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\KeuanganDetail;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\ProjectTeamFee;
use App\Models\Tagihan;
use App\Models\Team;
use App\Models\Termin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = now();

        if ($request->has('year')) {
            $year = $request->input('year', now()->year);
        };

        $projects = Project::get();
        $clients = Client::get();
        $teams = Team::get();

        $clientsLoad = Project::with('client')->where('status', 'deal')->paginate(5);
        $tagihansLoad = Tagihan::where('is_lunas', 0)->with('project')->orderBy('date_end', 'asc')->paginate(5);
        $piutangsLoad = Termin::with('keuangan_project')->orderByRaw('ABS(DATEDIFF(tanggal, CURDATE()))')->paginate(5);
        $feeteamsLoad = ProjectTeamFee::with('projectTeam')->where('tenggat', '<=', date('Y-m-d', strtotime('+2 weeks')))->where('status', 0)->orderBy('tenggat')->paginate(5);
        $keuangan = KeuanganDetail::selectRaw('MONTH(created_at) as month, SUM(total) as total')->whereYear('created_at', date($year))->where('status', 'pengeluaran')->groupBy('month')->orderBy('month')->get();
        $pemasukan = KeuanganDetail::selectRaw('MONTH(created_at) as month, SUM(total) as total')->whereYear('created_at', date($year))->where('status', 'pemasukan')->groupBy('month')->orderBy('month')->get();

        $labels = [];
        $dataPengeluaran = [];
        $dataPemasukan = [];
        $dataKeuntungan = [];

        $month = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];
        for ($i = 1; $i < 12; $i++) {
            $count = 0;

            foreach ($keuangan as $item) {
                if ($item->month == $i) {
                    $count = $item->total;
                    break;
                }
            }
            array_push($dataPengeluaran, $count);
        }
        $labels = $month;

        for ($i = 1; $i < 13; $i++) {
            $count = 0;

            foreach ($pemasukan as $item) {
                if ($item->month == $i) {
                    $count = $item->total;
                    break;
                }
            }

            array_push($dataPemasukan, $count);
        }


        for ($i = 0; $i < 12; $i++) {
            $income = isset($dataPemasukan[$i]) ? $dataPemasukan[$i] : 0;
            $expenses = isset($dataPengeluaran[$i]) ? $dataPengeluaran[$i] : 0;

            $profit = $income - $expenses;
            array_push($dataKeuntungan, $profit);
        }

        $datasets = [
            [
                'label' => 'Pemasukan',
                'data' => $dataPemasukan,
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgb(54, 162, 235)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Pengeluaran',
                'data' => $dataPengeluaran,
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255,99,132,1)',
                'borderWidth' => 1
            ],
            [
                'label' => 'Keuntungan',
                'data' => $dataKeuntungan,
                'backgroundColor' => 'rgba(55, 230, 87, 0.2)',
                'borderColor' => 'rgb(55, 230, 87)',
                'borderWidth' => 1
            ]
        ];

       if ($request->ajax()) {
            $clientsLoad = view('admin.dashboard.components.dataClients', compact('clientsLoad'))->render();
            $tagihansLoad = view('admin.dashboard.components.dataTagihans', compact('tagihansLoad'))->render();
            $piutangsLoad = view('admin.dashboard.components.dataPiutangs', compact('piutangsLoad'))->render();
            $feeteamsLoad = view('admin.dashboard.components.dataSisaFee', compact('feeteamsLoad'))->render();

            return response()->json(['client' => $clientsLoad, 'tagihan' => $tagihansLoad, 'piutang' => $piutangsLoad, 'feeteam' => $feeteamsLoad]);
        }
        return view('admin.dashboard.dashboard', compact('datasets','labels' ,'projects', 'clients', 'teams', 'clientsLoad', 'tagihansLoad', 'piutangsLoad', 'feeteamsLoad', 'keuangan'))->with('request');
    }
}
