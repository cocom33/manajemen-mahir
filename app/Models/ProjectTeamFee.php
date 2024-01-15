<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeamFee extends Model
{
    use HasFactory;

    protected $fillable = ['project_team_id', 'fee', 'photo'];

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
}