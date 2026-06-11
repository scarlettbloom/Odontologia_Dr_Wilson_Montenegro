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
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteVentaController;


// ═══════════════════════════════════════════════════════════════════
//  PÁGINAS PÚBLICAS
// ═══════════════════════════════════════════════════════════════════
Route::get('/',          [PageController::class, 'inicio'])->name('inicio');
Route::get('/mision',    [PageController::class, 'mision'])->name('mision');
Route::get('/vision',    [PageController::class, 'vision'])->name('vision');
Route::get('/objetivos', [PageController::class, 'objetivos'])->name('objetivos');
Route::get('/servicios', [PageController::class, 'servicios'])->name('servicios');

// ═══════════════════════════════════════════════════════════════════
//  AUTENTICACIÓN
// ═══════════════════════════════════════════════════════════════════
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);

Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ═══════════════════════════════════════════════════════════════════
//  ADMINISTRADOR — CRUD Citas
// ═══════════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/citas/pdf/{id}',[AdminCitaController::class, 'generarPdf'])->name('citas.pdf');
    Route::get('/citas',              [AdminCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas',             [AdminCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar',  [AdminCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}',         [AdminCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}',      [AdminCitaController::class, 'destroy'])->name('citas.destroy');
});

// ═══════════════════════════════════════════════════════════════════
//  EMPLEADO — CRUD Citas
// ═══════════════════════════════════════════════════════════════════
Route::prefix('empleado')->name('empleado.')->group(function () {
    Route::get('/citas/pdf/{id}',[EmpleadoCitaController::class, 'generarPdf'])->name('citas.pdf');
    Route::get('/citas',              [EmpleadoCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas',             [EmpleadoCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar',  [EmpleadoCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}',         [EmpleadoCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}',      [EmpleadoCitaController::class, 'destroy'])->name('citas.destroy');
});

// ═══════════════════════════════════════════════════════════════════
//  CLIENTE — CRUD Citas
// ═══════════════════════════════════════════════════════════════════
Route::prefix('cliente')->name('cliente.')->middleware('cliente')->group(function () {
    Route::get('/citas/pdf/{id}',[ClienteCitaController::class, 'generarPdf'])->name('citas.pdf');
    Route::get('/citas',              [ClienteCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas',             [ClienteCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar',  [ClienteCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}',         [ClienteCitaController::class, 'update'])->name('citas.update');
});

// ═══════════════════════════════════════════════════════════════════
//  INVENTARIO — ADMIN Y EMPLEADO
// ═══════════════════════════════════════════════════════════════════
Route::get('/inventario/{id}/delete', [InventarioController::class, 'confirmDelete'])
     ->name('inventario.delete');

Route::get('/inventario/movimientostock', function () {
    return view('admin.movimientostock');
})->name('inventario.movimientostock');

Route::get('/inventario/carrito', [InventarioController::class, 'carrito'])
        ->name('cliente.inventario.carrito');

Route::resource('inventario', InventarioController::class);

// ═══════════════════════════════════════════════════════════════════
//  INVENTARIO — CLIENTE
// ═══════════════════════════════════════════════════════════════════
Route::prefix('cliente')->middleware('cliente')->group(function () {

    Route::get('/inventario', [InventarioController::class, 'clienteIndex'])
        ->name('cliente.inventario');

    Route::get('/inventario/{id}', [InventarioController::class, 'clienteShow'])
        ->name('cliente.inventario.detalle');

    Route::get('/carrito', [ClienteVentaController::class, 'verCarrito'])
        ->name('cliente.carrito.ver');

    Route::post('/checkout', [ClienteVentaController::class, 'checkout'])
        ->name('cliente.checkout');
});

// ═══════════════════════════════════════════════════════════════════
//  MOVIMIENTO DE STOCK
// ═══════════════════════════════════════════════════════════════════
Route::get('/admin/movimientostock', function () {
    return view('admin.movimientostock');
})->name('admin.movimientostock');

// ═══════════════════════════════════════════════════════════════════
//  SERVICIOS
// ═══════════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.servicios.')->group(function () {

    Route::get('/servicios', [ServicioController::class, 'index'])->name('index');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('create');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('store');
    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])->name('edit');
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('destroy');

});

// ═══════════════════════════════════════════════════════════════════
//  VENTAS — ADMINISTRADOR
// ═══════════════════════════════════════════════════════════════════
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/ventas', [VentaController::class, 'index'])->name('admin.ventas.index');
    Route::post('/ventas', [VentaController::class, 'store'])->name('admin.ventas.store');
    Route::get('/ventas/descuento', [VentaController::class, 'descuento'])->name('admin.ventas.descuento');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('admin.ventas.reporte');
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('admin.ventas.create');
});

// ═══════════════════════════════════════════════════════════════════
//  VENTAS — EMPLEADO
// ═══════════════════════════════════════════════════════════════════
Route::prefix('empleado')->middleware('empleado')->group(function () {
    Route::get('/ventas', [VentaController::class, 'index'])->name('empleado.ventas.index');
    Route::post('/ventas', [VentaController::class, 'store'])->name('empleado.ventas.store');
    Route::get('/ventas/descuento', [VentaController::class, 'descuento'])->name('empleado.ventas.descuento');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('empleado.ventas.reporte');
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('empleado.ventas.create');
});

Route::get('/admin/ventas/reporte', [VentaController::class, 'reporte'])
    ->name('admin.ventas.reporte');

// CLIENTE ventas
Route::get('/cliente/inventario', [ClienteVentaController::class, 'index'])->name('cliente.inventario');
Route::post('/cliente/venta', [ClienteVentaController::class, 'store'])->name('cliente.venta.store');

Route::get('/cliente/compras', [ClienteVentaController::class, 'compras'])
    ->name('cliente.compras');

Route::post('/cliente/venta', [ClienteVentaController::class, 'store'])
    ->name('cliente.venta.store');

Route::post('/checkout', [ClienteVentaController::class, 'checkout'])
    ->name('cliente.checkout');

Route::get('/compras', [ClienteVentaController::class, 'compras'])
    ->name('cliente.compras');



Route::get('/servicios-publicos', function () {
    return view('servicios.publicos');
})->name('servicios.publicos');
