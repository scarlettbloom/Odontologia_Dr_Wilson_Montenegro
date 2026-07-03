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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\ProveedorController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'inicio'])->name('inicio');
Route::get('/mision', [PageController::class, 'mision'])->name('mision');
Route::get('/vision', [PageController::class, 'vision'])->name('vision');
Route::get('/objetivos', [PageController::class, 'objetivos'])->name('objetivos');
Route::get('/servicios', [PageController::class, 'servicios'])->name('servicios');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {

    // CITAS
    Route::get('/citas', [AdminCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas', [AdminCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [AdminCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}', [AdminCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}', [AdminCitaController::class, 'destroy'])->name('citas.destroy');
    Route::get('/citas/pdf/{id}', [AdminCitaController::class, 'generarPdf'])->name('citas.pdf');
    Route::get('/factura/excel/{id}',[AdminCitaController::class,'generarExcel'])->name('factura.excel');

    // SERVICIOS
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
    Route::put('/servicios/{id}', [ServicioitorioController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

    // VENTAS
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/descuento', [VentaController::class, 'descuento'])->name('ventas.descuento');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('ventas.reporte');
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::get('/ventas/pdf/{id}',[VentaController::class, 'generarPdf'])->name('ventas.pdf');
    Route::get('/ventas/excel/{id}',[VentaController::class,'generarExcel'])->name('ventas.excel');

    // INVENTARIO (ADMIN)
    Route::resource('inventario', InventarioController::class);
    Route::get('/inventario/{id}/delete', [InventarioController::class, 'confirmDelete'])->name('inventario.delete');
    Route::get('/inventario/{id}/toggle', [InventarioController::class, 'toggleEstado'])->name('inventario.toggle');

    // PROVEEDORES (ADMIN)
    Route::resource('proveedors', ProveedorController::class);
    Route::get('/proveedors/{id}/delete', [ProveedorController::class, 'confirmDelete'])->name('proveedors.delete');

    // MOVIMIENTO DE STOCK (ADMIN)
    Route::get('/movimiento_stock', [InventarioController::class, 'movimiento'])->name('inventario.movimiento_stock');

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // USUARIOS
    Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [AdminUsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/editar', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [AdminUsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

/*
|--------------------------------------------------------------------------
| EMPLEADO
|--------------------------------------------------------------------------
*/
Route::prefix('empleado')->middleware('empleado')->name('empleado.')->group(function () {

    // CITAS
    Route::get('/citas', [EmpleadoCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas', [EmpleadoCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [EmpleadoCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}', [EmpleadoCitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}', [EmpleadoCitaController::class, 'destroy'])->name('citas.destroy');
    Route::get('/citas/pdf/{id}', [EmpleadoCitaController::class, 'generarPdf'])->name('citas.pdf');

    // SERVICIOS
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

    Route::get('/factura/excel/{id}',[EmpleadoCitaController::class,'generarExcel'])->name('factura.excel');

    // VENTAS
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/descuento', [VentaController::class, 'descuento'])->name('ventas.descuento');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('ventas.reporte');
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::get('/ventas/pdf/{id}',[VentaController::class, 'generarPdf'])->name('ventas.pdf');
    Route::get('/ventas/excel/{id}',[VentaController::class,'generarExcel'])->name('ventas.excel');

    // INVENTARIO (EMPLEADO)
    Route::resource('inventario', InventarioController::class);
    Route::get('/inventario/{id}/delete', [InventarioController::class, 'confirmDelete'])->name('inventario.delete');

    // MOVIMIENTO DE STOCK (EMPLEADO)
    Route::get('/movimiento_stock', [InventarioController::class, 'movimiento'])->name('inventario.movimiento_stock');

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/
Route::prefix('cliente')->middleware('cliente')->name('cliente.')->group(function () {

    Route::put('/carrito/actualizar/{id}', [ClienteVentaController::class, 'actualizarCantidad'])
        ->name('carrito.actualizar');

    // CITAS
    Route::get('/citas', [ClienteCitaController::class, 'index'])->name('citas.index');
    Route::post('/citas', [ClienteCitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/{id}/editar', [ClienteCitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}', [ClienteCitaController::class, 'update'])->name('citas.update');
    Route::get('/citas/pdf/{id}', [ClienteCitaController::class, 'generarPdf'])->name('citas.pdf');
    Route::get('/factura/excel/{id}',[ClienteCitaController::class,'generarExcel'])->name('factura.excel');

    // INVENTARIO CLIENTE
    Route::get('/inventario', [InventarioController::class, 'clienteIndex'])->name('inventario');
    Route::get('/inventario/{id}', [InventarioController::class, 'clienteShow'])->name('inventario.detalle');

    // CARRITO Y VENTAS CLIENTE
    Route::get('/carrito', [ClienteVentaController::class, 'verCarrito'])->name('carrito.ver');
    Route::get('/carrito/eliminar/{id}', [ClienteVentaController::class, 'eliminarDelCarrito'])->name('carrito.eliminar');
    Route::get('/inventario/{id}/carrito', [ClienteVentaController::class, 'addToCart'])->name('inventario.carrito');
    Route::post('/checkout', [ClienteVentaController::class, 'checkout'])->name('checkout');
    Route::get('/compras', [ClienteVentaController::class, 'compras'])->name('compras');
    Route::post('/checkout/form', [ClienteVentaController::class, 'checkoutForm'])->name('checkout_form');
});

/*
|--------------------------------------------------------------------------
| SERVICIOS PÚBLICOS
|--------------------------------------------------------------------------
*/
Route::get('/servicios-publicos', fn() => view('servicios.publicos'))->name('servicios.publicos');

