<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminCitaController;
use App\Http\Controllers\EmpleadoCitaController;
use App\Http\Controllers\ClienteCitaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SolicitudServicioController;

// ═══════════════════════════════════════════════════════════════════
//  PÁGINAS PÚBLICAS
//  Origen: inicio.php, mision.php, vision.php, objetivos.php, servicios.php
// ═══════════════════════════════════════════════════════════════════
Route::get('/',          [PageController::class, 'inicio'])->name('inicio');
Route::get('/mision',    [PageController::class, 'mision'])->name('mision');
Route::get('/vision',    [PageController::class, 'vision'])->name('vision');
Route::get('/objetivos', [PageController::class, 'objetivos'])->name('objetivos');
Route::get('/servicios', [PageController::class, 'servicios'])->name('servicios');

// ═══════════════════════════════════════════════════════════════════
//  AUTENTICACIÓN
//  Origen: login.php, register.php, logout.php
//  La validación de sesión (session.php) se maneja con middleware en
//  cada controlador de rol.
// ═══════════════════════════════════════════════════════════════════
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);

Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ═══════════════════════════════════════════════════════════════════
//  ADMINISTRADOR — CRUD completo de citas
//  Origen: citas.php
// ═══════════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/citas',              [AdminCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas',             [AdminCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar',  [AdminCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}',         [AdminCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}',      [AdminCitaController::class, 'destroy'])->name('citas.destroy');
});

// ═══════════════════════════════════════════════════════════════════
//  EMPLEADO — CRUD completo de citas
//  Origen: empleado.php
// ═══════════════════════════════════════════════════════════════════
Route::prefix('empleado')->name('empleado.')->group(function () {
    Route::get('/citas',              [EmpleadoCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas',             [EmpleadoCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar',  [EmpleadoCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}',         [EmpleadoCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}',      [EmpleadoCitaController::class, 'destroy'])->name('citas.destroy');
});

// ═══════════════════════════════════════════════════════════════════
//  CLIENTE — agendar y editar (siempre queda en Pendiente)
//  Origen: Citacliente.php
// ═══════════════════════════════════════════════════════════════════
Route::prefix('cliente')->name('cliente.')->middleware('cliente')->group(function () {
    Route::get('/citas',              [ClienteCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas',             [ClienteCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar',  [ClienteCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}',         [ClienteCitaController::class, 'update'])->name('citas.update');

});

// ═══════════════════════════════════════════════════════════════════
//  INVENTARIO — ADMIN Y EMPLEADO (NO SE TOCA NADA)
// ═══════════════════════════════════════════════════════════════════
Route::get('/inventario/{id}/delete', [InventarioController::class, 'confirmDelete'])
     ->name('inventario.delete');

Route::get('/inventario/movimientostock', function () {
    return view('admin.movimientostock');
})->name('inventario.movimientostock');

Route::resource('inventario', InventarioController::class);

// ═══════════════════════════════════════════════════════════════════
//  INVENTARIO — CLIENTE (USANDO EL MISMO CONTROLADOR)
// ═══════════════════════════════════════════════════════════════════
Route::prefix('cliente')->middleware('cliente')->group(function () {

    Route::get('/inventario', [InventarioController::class, 'clienteIndex'])
        ->name('cliente.inventario');

    Route::get('/inventario/{id}', [InventarioController::class, 'clienteShow'])
        ->name('cliente.inventario.detalle');

    Route::get('/inventario/carrito', [InventarioController::class, 'carrito'])
        ->name('cliente.inventario.carrito');
});

Route::get('/inventario/{id}/delete', [InventarioController::class, 'confirmDelete'])
     ->name('inventario.delete');

// Movimiento de stock (vista aparte)
Route::get('/inventario/movimientostock', function () {
    return view('inventario.movimientostock');
})->name('inventario.movimientostock');

Route::resource('inventario', InventarioController::class);



Route::prefix('cliente')->group(function () {

    Route::get('/productos', [ClienteController::class, 'productos'])
        ->name('cliente.productos');

    Route::get('/producto/{id}', [ClienteController::class, 'detalle'])
        ->name('cliente.producto.detalle');

    Route::get('/carrito', [ClienteController::class, 'carrito'])
        ->name('cliente.carrito');
});

//servicios//

Route::prefix('admin')->name('admin.servicios.')->group(function () {

    Route::get('/servicios', [ServicioController::class, 'index'])
        ->name('index');

    Route::get('/servicios/create', [ServicioController::class, 'create'])
        ->name('create');

    Route::post('/servicios', [ServicioController::class, 'store'])
        ->name('store');

    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])
        ->name('edit');

    Route::put('/servicios/{id}', [ServicioController::class, 'update'])
        ->name('update');

    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])
        ->name('destroy');

});
