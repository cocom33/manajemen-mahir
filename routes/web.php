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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
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
// Route::get('/dashboard', function () {
//     return view('pages.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contoh', [ContohController::class, 'index'])->name('contoh');

    // profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // end profile

    // team
    Route::resource('teams', TeamController::class);

    // end team

    // client
    Route::resource('client', ClientController::class);
    // end client

    // project
    Route::get('/project', [PorjectController::class, 'index'])->name('project');
    Route::get('/project-create', [PorjectController::class, 'form'])->name('project.create');
    Route::post('/project-store', [PorjectController::class, 'store'])->name('project.store');
    Route::get('/project/{slug}/edit', [PorjectController::class, 'form'])->name('project.edit');
    Route::put('/project/{slug}/update', [PorjectController::class, 'update'])->name('project.update');
    Route::delete('/project/{slug}', [PorjectController::class, 'delete'])->name('project.delete');

    Route::get('/project/{slug}', [PorjectController::class, 'projectDetail'])->name('project.detail');

    Route::get('/project/{slug}/team', [PorjectController::class, 'projectTeam'])->name('project.team');
    Route::get('/project/{slug}/add-team', [PorjectController::class, 'projectAddTeam'])->name('project.team.add');
    Route::post('/project/{slug}/team-store', [PorjectController::class, 'projectDetailTeamStore'])->name('project.detail.team');

    Route::get('/project/{slug}/lampiran', [PorjectController::class, 'projectLampiran'])->name('project.lampiran');

    Route::get('/project/{slug}/fee', [PorjectController::class, 'projectFee'])->name('project.fee');

    Route::get('/project/{slug}/invoice', [PorjectController::class, 'projectInvoice'])->name('project.invoice');
    // end project

    // project type
    Route::get('/project-type', [PorjectTypeController::class, 'index'])->name('project-type');
    // end project type

    // keuangan umum
    Route::get('keuangan-umum', [KeuanganUmumController::class, 'index'])->name('keuangan-umum');
    // end keuangan umum

    // keuangan perusahaan
    Route::get('keuangan-perusahaan', [KeuanganPerusahaanController::class, 'index'])->name('keuangan-perusahaan');
    // end keuangan perusahaan
});

require __DIR__.'/auth.php';