<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\ApoyoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Beneficiarios
    Route::resource('beneficiarios', BeneficiarioController::class);

    // Apoyos
    Route::resource('apoyos', ApoyoController::class)->except(['show']);

    // Actividades
    Route::resource('actividades', ActividadController::class)
        ->parameters(['actividades' => 'actividad'])
        ->except(['show']);

    // Asistencia
    Route::get('asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::post('asistencia', [AsistenciaController::class, 'store'])->name('asistencia.store');
    Route::get('asistencia/historial', [AsistenciaController::class, 'historial'])->name('asistencia.historial');
    Route::get('asistencia/personas', [AsistenciaController::class, 'personas'])->name('asistencia.personas');
    Route::get('asistencia/pdf', [AsistenciaController::class, 'pdf'])->name('asistencia.pdf');

    // Exportaciones
    Route::get('exportar/beneficiarios', [ExportController::class, 'beneficiarios'])->name('beneficiarios.export');
    Route::get('exportar/apoyos', [ExportController::class, 'apoyos'])->name('apoyos.export');
    Route::get('exportar/actividades', [ExportController::class, 'actividades'])->name('actividades.export');
    Route::get('exportar/asistencia', [ExportController::class, 'asistencia'])->name('asistencia.export');
});

require __DIR__.'/auth.php';
