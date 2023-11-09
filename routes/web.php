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
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\TeamController;
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
});

    // Profile
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
    // end project

    // project type
    Route::resource('project-type', ProjectTypeController::class);
    // end project type

    // keuangan umum
    Route::resource('keuangan-umum', KeuanganUmumController::class);
    // end keuangan umum

    // keuangan perusahaan
    Route::get('keuangan-perusahaan', [KeuanganPerusahaanController::class, 'index'])->name('keuangan-perusahaan');
    // end keuangan perusahaan
});

require __DIR__.'/auth.php';
