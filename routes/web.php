<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PorjectController;
use App\Http\Controllers\ContohController;
use App\Http\Controllers\KeuanganPerusahaanController;
use App\Http\Controllers\KeuanganUmumController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PorjectTeamController;
use App\Http\Controllers\PorjectTypeController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectFeeController;
use App\Http\Controllers\ProjectTeamsController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TagihanClientController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Models\KeuanganUmum;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//CRUD TEAM

Route::middleware(['auth', 'verified'])->group(function () {

    // profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // end profile

    // routes/web.php
    Route::resource('teams', TeamController::class);

    Route::get('/project/{slug}/team', [ProjectTeamsController::class, 'projectTeam'])->name('project.team');
    Route::get('/project/teams-detail/{slug}/{id}', [ProjectTeamsController::class, 'show'])->name('project.teams.show');
    Route::put('/project/{slug}/team-store', [ProjectTeamsController::class, 'projectAddTeam'])->name('project.add.team');
    Route::put('/project/{slug}/team-edit', [ProjectTeamsController::class, 'projectEditTeam'])->name('project.edit.team');
    Route::delete('/project/{slug}/team-destroy/{id}', [ProjectTeamsController::class, 'projectDeleteTeam'])->name('project.delete.team');

    Route::put('/project/{slug}/team-lunas/{id}', [ProjectTeamsController::class, 'projectTeamLunas'])->name('project.team.lunas');

    Route::put('/projects/{project}/teams/{team}/fees', [ProjectTeamsController::class , 'update'])->name('project.team.fee.update');
    Route::delete('/project/team-fee/delete/{id}', [ProjectTeamsController::class, 'deleteFee'])->name('project.team-fee-delete');

    //Notes
    // Route::get('/notes', [NoteController::class, 'index'])->name('note.index');

    // Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');

    // Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');

    // Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');

    // Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::resource('notes', NoteController::class);


    // client
    Route::resource('client', ClientController::class);
    // end client

    // Skill
    Route::resource('skill', SkillController::class);
    // end Skill

    // Perusahaan
    Route::resource('perusahaan', PerusahaanController::class);
    // End Perusahaan

    // project
    Route::get('/projects', [PorjectController::class, 'index'])->name('projects');
    Route::get('/project-create', [PorjectController::class, 'form'])->name('project.create');
    Route::post('/project-store', [PorjectController::class, 'store'])->name('project.store');
    Route::get('/project/{slug}/edit', [PorjectController::class, 'form'])->name('project.edit');
    Route::put('/project/{slug}/update', [PorjectController::class, 'update'])->name('project.update');
    Route::delete('/project/{slug}', [PorjectController::class, 'delete'])->name('project.delete');

    Route::get('/project/{slug}', [PorjectController::class, 'projectDetail'])->name('project.detail');

    Route::get('/project/{slug}/lampiran', [PorjectController::class, 'projectLampiran'])->name('project.lampiran');
    Route::post('/project/{slug}/add-lampiran', [PorjectController::class, 'projectLampiranStore'])->name('project.lampiran.upload');
    Route::get('/project/{slug}/lampiran/{id}/edit', [PorjectController::class, 'projectLampiranEdit'])->name('project.lampiran.edit');
    Route::put('/project/{slug}/lampiran/{id}/update', [PorjectController::class, 'projectLampiranUpdate'])->name('project.lampiran.update');
    Route::delete('/project/{slug}/lampiran/{id}/delete', [PorjectController::class, 'projectLampiranDestroy'])->name('project.lampiran.destroy');

    Route::get('/project/{slug}/pemasukan', [ProjectFeeController::class, 'projectFee'])->name('project.pemasukan');
    Route::post('/project/{slug}/pemasukan/create', [ProjectFeeController::class, ''])->name('project.pemasukan.create');
    Route::post('/project/{slug}/pemasukan/create', [ProjectFeeController::class, 'projectFeeStore'])->name('project.pemasukan.create');
    Route::delete('/project/{slug}/pemasukan/{id}/delete', [ProjectFeeController::class, 'deleteTipePembayaran'])->name('project.pemasukan.destroy');

    Route::post('/project/{slug}/pemasukan/langsung/create', [ProjectFeeController::class, 'projectFeeLangsungStore'])->name('project.pemasukan.langsung.store');

    Route::put('/project/{slug}/pemasukan/langsung/create', [ProjectFeeController::class, 'projectFeeLangsungStore'])->name('project.pemasukan.langsung.store');
    Route::put('/project/{slug}/pemasukan/langsung/update', [ProjectFeeController::class, 'projectFeeLangsungUpdate'])->name('project.pemasukan.langsung.update');
    Route::delete('/project/{slug}/pemasukan/langsung/{id}/delete', [ProjectFeeController::class, 'deleteLampiranLangsung'])->name('project.pemasukan.langsung.lampiran.destroy');
    Route::put('/project/{slug}/pemasukan/termin/create', [ProjectFeeController::class, 'projectTerminStore'])->name('project.pemasukan.termin.store');
    Route::get('/project/{slug}/pemasukan/termin/{termin}', [ProjectFeeController::class, 'projectTerminDetail'])->name('project.pemasukan.termin.detail');
    Route::put('/project/{slug}/pemasukan/termin/{termin}/update', [ProjectFeeController::class, 'projectTerminDetailStore'])->name('project.pemasukan.termin.detail.store');

    Route::delete('/projects/{slug}/termins/{id}/delete', [ProjectFeeController::class, 'deleteLampiranTermin'])->name('project.lampiran.pemasukan.destroy');

    Route::get('/project/{slug}/tagihan', [TagihanController::class, 'index'])->name('project.tagihan');
    Route::post('/project/{slug}/tagihan/store', [TagihanController::class, 'store'])->name('project.tagihan.store');
    Route::put('/project/{slug}/tagihan/update', [TagihanController::class, 'update'])->name('project.tagihan.update');
    Route::get('/project/{slug}/tagihan/{id}/edit', [TagihanController::class, 'edit'])->name('project.tagihan.edit');
    Route::get('/project/{slug}/tagihan/{id}/detail', [TagihanController::class, 'detail'])->name('project.tagihan.detail');
    Route::delete('/project/{slug}/tagihan/{id}/delete', [TagihanController::class, 'delete'])->name('project.tagihan.delete');
    Route::put('/project/{slug}/tagihan/lunas', [TagihanController::class, 'lunas'])->name('project.tagihan.lunas');
    Route::put('/project/{slug}/tagihan/clone', [TagihanController::class, 'clone'])->name('project.tagihan.clone');
    Route::put('/project/{slug}/tagihan/non-aktif', [TagihanController::class, 'nonAktif'])->name('project.tagihan.non-aktif');

    Route::get('/project/{slug}/pengeluaran', [PengeluaranController::class, 'index'])->name('project.pengeluaran');
    Route::get('/project/{slug}/pengeluaran/{id}', [PengeluaranController::class, 'show'])->name('project.pengeluaran.show');
    Route::get('/project/{slug}/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit'])->name('project.pengeluaran.edit');
    Route::post('/project/{slug}/pengeluaran/store', [PengeluaranController::class, 'store'])->name('project.pengeluaran.store');
    Route::put('/project/{slug}/pengeluaran/update/{id}', [PengeluaranController::class, 'update'])->name('project.pengeluaran.update');
    Route::delete('/project/{slug}/pengeluaran/{id}', [PengeluaranController::class, 'delete'])->name('project.pengeluaran.delete');

    Route::get('/project/{slug}/laporan', [PengeluaranController::class, 'laporan'])->name('project.laporan');

    // end project

    // tagihan
    Route::get('/tagihan', [TagihanController::class, 'list'])->name('tagihan');
    Route::get('/tagihan/create', [TagihanClientController::class, 'form'])->name('tagihan.create');
    Route::post('/tagihan/store', [TagihanClientController::class, 'store'])->name('tagihan.store');
    Route::get('/tagihan/{id}', [TagihanClientController::class, 'show'])->name('tagihan.show');
    Route::get('/tagihan/{id}/edit', [TagihanClientController::class, 'form'])->name('tagihan.edit');
    Route::put('/tagihan/update/{id}', [TagihanClientController::class, 'update'])->name('tagihan.update');
    Route::delete('/tagihan/{id}', [TagihanClientController::class, 'delete'])->name('tagihan.delete');
    Route::put('/tagihan/{id}/lunas', [TagihanClientController::class, 'lunas'])->name('tagihan.lunas');
    Route::put('/tagihan/{id}/clone', [TagihanClientController::class, 'clone'])->name('tagihan.clone');
    Route::put('/tagihan/{id}/non-aktif', [TagihanController::class, 'nonAktif'])->name('tagihan.non-aktif');
    // end tagihan

    //export excel & Csv
    Route::get('/export-keuangan-xlsx',[KeuanganPerusahaanController::class, 'exportKeuangans'])->name('export-keuangans');
    Route::get('/export-keuangan-csf',[KeuanganPerusahaanController::class, 'exportKeuangansCsv'])->name('export-keuangans-csv');
    //end export excel & Csv

    // project type
    Route::resource('category-project', ProjectTypeController::class);
    // end project type

    // bank
    Route::resource('banks', BankController::class);
    // end bank

    // suppliers
    Route::resource('suppliers', SupplierController::class);
    // end suppliers

    // users
    Route::resource('users', UserController::class);
    // end users

    // keuangan umum
    Route::resource('keuangan-umum', KeuanganPerusahaanController::class);
    // end keuangan umum
});

require __DIR__.'/auth.php';