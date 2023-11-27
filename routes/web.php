<?php

use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ExtraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\TipoEquipoController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'tipoequipo'], function () {
    Route::controller(TipoEquipoController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('tipoequipo.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('tipoequipo.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('tipoequipo.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('tipoequipo.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('tipoequipo.update');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('tipoequipo.desactive');
    });
});

Route::group(['prefix' => 'set'], function () {
    Route::controller(SetController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('set.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('set.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('set.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('set.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('set.update');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('set.desactive');
    });
});

Route::group(['prefix' => 'extra'], function () {
    Route::controller(ExtraController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('extra.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('extra.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('extra.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('extra.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('extra.update');
        Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('extra.desactive');
    });
});

Route::group(['prefix' => 'equipo'], function () {
    Route::controller(EquipoController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('equipo.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('equipo.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('equipo.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('equipo.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('equipo.update');
        // Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('equipo.desactive');
    });
});

Route::group(['prefix' => 'asistente'], function () {
    Route::controller(AsistenteController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('asistente.index');
        Route::get('/create', 'create')->middleware(['auth'])->name('asistente.create');
        Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('asistente.edit');
        Route::post('/store', 'store')->middleware(['auth'])->name('asistente.store');
        Route::post('/update/{id}', 'update')->middleware(['auth'])->name('asistente.update');
        // Route::get('/desactive/{id}', 'desactive')->middleware(['auth'])->name('equipo.desactive');
    });
});

Route::group(['prefix' => 'reserva'], function () {
    Route::controller(ReservaController::class)->group(function () {
        Route::get('/', 'index')->middleware(['auth'])->name('reserva.index');
        Route::get('/calendario', 'calendario')->middleware(['auth'])->name('reserva.calendario');
        Route::get('/create', 'create')->middleware(['auth'])->name('reserva.create');
        Route::get('/validarReserva', 'validarReserva')->middleware(['auth'])->name('reserva.validarReserva');
        // Route::get('/edit/{id}', 'edit')->middleware(['auth'])->name('reserva.edit');
        Route::get('/show/{id}', 'show')->middleware(['auth'])->name('reserva.show');
        Route::post('/store', 'store')->middleware(['auth'])->name('reserva.store');
        // Route::post('/update/{id}', 'update')->middleware(['auth'])->name('reserva.update');
    });
});

require __DIR__ . '/auth.php';
