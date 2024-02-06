<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeamFee extends Model
{
    use HasFactory;

    protected $fillable = ['project_team_id', 'fee', 'photo', 'bank_id', 'bank', 'nasabah_kantor', 'nasabah_team', 'tenggat', 'status'];

    public function pengeluaran()
    {
        $this->belongsTo(Pengeluaran::class);
    }

    public function projectTeam()
    {
        return $this->belongsTo(ProjectTeam::class);
    }

    public function scopeTahun($query, $tahun, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::createFromDate($tahun, 1, 1), Carbon::createFromDate($tahun, 12, 31)]);
    }

    public function scopeBulan($query, $bulan, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::createFromDate(date('Y'), $bulan, 1), Carbon::createFromDate(date('Y'), $bulan, 31)]);
    }

    public function scopeTahunBulan($query, $tahun, $bulan, $column = 'created_at')
    {
        return $query->whereBetween($column, [Carbon::createFromDate($tahun, $bulan, 1), Carbon::createFromDate($tahun, $bulan, 31)]);
    }

    public function setNasabahTeamAttribute($value)
    {
    if(!$value) {

        // ambil data nasabah team dari project team
        $team = $this->projectTeam; 
        $nasabah = $team->nasabah;

        // isi nilai nasabah team dengan data project team
        $this->attributes['nasabah_team'] = $nasabah;

    } else {

        $this->attributes['nasabah_team'] = $value;
    
    }
    }
}