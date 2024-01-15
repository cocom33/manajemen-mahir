<?php

namespace App\Livewire;

use App\Models\ProjectTeam;
use App\Models\ProjectTeamFee;
use Livewire\Component;

class KeuanganTeam extends Component
{
    public $tahun;
    public $bulan;
    public $id;

    public function mount($id)
    {
        $this->tahun = 'semua';
        $this->bulan = 'semua';
        $this->id = $id;
    }

    public function render()
    {
        $projectTeam = ProjectTeam::where('team_id', $this->id)->pluck('id');
        $data['all'] = ProjectTeamFee::whereIn('project_team_id', $projectTeam)->groupBy('created_at')->pluck('created_at');

        $data['fee'] = ProjectTeamFee::whereIn('project_team_id', $projectTeam)->get();
        if($this->tahun != 'semua') {
            $data['fee'] = ProjectTeamFee::whereIn('project_team_id', $projectTeam)->tahun($this->tahun)->get();
        }
        if($this->bulan != 'semua') {
            $data['fee'] = ProjectTeamFee::whereIn('project_team_id', $projectTeam)->bulan($this->bulan)->get();
        }
        if($this->bulan != 'semua' && $this->tahun != 'semua') {
            $data['fee'] = ProjectTeamFee::whereIn('project_team_id', $projectTeam)->tahunBulan($this->tahun, $this->bulan)->get();
        }

        return view('livewire.keuangan-team', $data);
    }

    public function changeb($bulan)
    {
        $this->bulan = $bulan;
    }

    public function changet($tahun)
    {
        $this->tahun = $tahun;
    }
}