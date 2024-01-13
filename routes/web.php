<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PorjectController;
use App\Http\Controllers\ContohController;
use App\Http\Controllers\KeuanganPerusahaanController;
use App\Http\Controllers\KeuanganUmumController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PorjectTeamController;
use App\Http\Controllers\PorjectTypeController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectFeeController;
use App\Http\Controllers\ProjectTeamsController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TagihanClientController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Models\KeuanganUmum;
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
    Route::get('/project/teams-fee', [ProjectTeamsController::class])->name('teams.fee');

    Route::get('/project/teams-details/{slug}/{id}', [ProjectTeamsController::class, 'show'])->name('project.teams.show');
    // team
    // routes/web.php
    Route::resource('teams', TeamController::class);

    Route::put('/projects/{project}/teams/{team}/fees', [ProjectTeamsController::class , 'update'])->name('project.team.fee.update');

    Route::delete('/projects/{project}/teams/{team}/delete', [ProjectTeamsController::class, 'deletePhoto'])->name('project.team.fee.destroy');
    Route::delete('/project/team-fee/delete/{id}', [ProjectTeamsController::class, 'deleteFee'])->name('project.team-fee-delete');



    // end team

    // client
    Route::resource('client', ClientController::class);
    // end client

    // Skill
    Route::resource('skill', SkillController::class);
    Route::post('ckeditor/upload', [SkillController::class, 'upload'])->name('ckeditor.upload');
    // end Skill

    // project
    Route::get('/projects', [PorjectController::class, 'index'])->name('projects');
    Route::get('/project-create', [PorjectController::class, 'form'])->name('project.create');
    Route::post('/project-store', [PorjectController::class, 'store'])->name('project.store');
    Route::get('/project/{slug}/edit', [PorjectController::class, 'form'])->name('project.edit');
    Route::put('/project/{slug}/update', [PorjectController::class, 'update'])->name('project.update');
    Route::delete('/project/{slug}', [PorjectController::class, 'delete'])->name('project.delete');

    Route::get('/project/{slug}', [PorjectController::class, 'projectDetail'])->name('project.detail');

    Route::get('/project/{slug}/team', [PorjectController::class, 'projectTeam'])->name('project.team');
    Route::put('/project/{slug}/team-store', [PorjectController::class, 'projectAddTeam'])->name('project.add.team');
    Route::put('/project/{slug}/team-edit', [PorjectController::class, 'projectEditTeam'])->name('project.edit.team');
    Route::delete('/project/{slug}/team-destroy/{id}', [PorjectController::class, 'projectDeleteTeam'])->name('project.delete.team');

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

    Route::get('/project/{slug}/invoice', [InvoiceController::class, 'index'])->name('project.invoice');
    Route::post('/project/{slug}/invoice', [InvoiceController::class, 'store'])->name('project.invoice.create');
    Route::get('/project/{slug}/invoice/detail/{id}', [InvoiceController::class, 'detail'])->name('project.invoice.detail');
    Route::get('/project/{slug}/invoice/download/{id}', [InvoiceController::class, 'downloadInvoice'])->name('project.invoice.download');
    Route::put('/project/{slug}/invoice-system/store', [InvoiceController::class, 'invoiceSystemStore'])->name('project.invoice.system.create');
    Route::put('/project/{slug}/invoice-other/store', [InvoiceController::class, 'invoiceOtherStore'])->name('project.invoice.other.create');
    Route::delete('/project/{slug}/invoice-system/{id}/delete', [InvoiceController::class, 'invoiceSystemDestroy'])->name('project.invoice.system.delete');
    Route::delete('/project/{slug}/invoice-other/{id}/delete', [InvoiceController::class, 'invoiceOtherDestroy'])->name('project.invoice.other.delete');
    Route::post('/project/{slug}/invoice/add-invoice', [PorjectController::class, 'projectInvoiceStore'])->name('project.invoice.store');
    Route::get('/project/{slug}/invoice/{id}/stream', [PorjectController::class, 'getInvoices'])->name('project.invoice.stream');

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

    // project type
    Route::resource('category-project', ProjectTypeController::class);
    // end project type

    // project type
    Route::resource('users', UserController::class);
    // end project type

    // keuangan umum
    Route::resource('keuangan-umum', KeuanganPerusahaanController::class);
    // end keuangan umum
});

require __DIR__.'/auth.php';
