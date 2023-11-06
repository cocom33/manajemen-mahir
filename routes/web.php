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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contoh', [ContohController::class, 'index'])->name('contoh');

    // profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('teams', TeamController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // end profile

    // team
    Route::get('/team', [TeamController::class, 'index'])->name('team');
    // end team

    // client
    Route::get('/client', [ClientController::class, 'index'])->name('client');
    // end client

    // project
    Route::get('/project', [PorjectController::class, 'index'])->name('project');
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