<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CelularesController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VentasController;
use App\Models\Ventas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Celulares
Route::get('celulares', [CelularesController::class, 'index'])
    ->name('celulares')
    ->middleware('auth');

Route::get('celulares/create', [CelularesController::class, 'create'])
    ->name('celulares.create')
    ->middleware('auth');

Route::post('celulares', [CelularesController::class, 'store'])
    ->name('celulares.store')
    ->middleware('auth');

Route::get('celulares/{celular_id}/edit', [CelularesController::class, 'edit'])
    ->name('celulares.edit')
    ->middleware('auth');

Route::put('celulares/{celular_id}', [CelularesController::class, 'update'])
    ->name('celulares.update')
    ->middleware('auth');

Route::delete('celulares/{celular_id}', [CelularesController::class, 'destroy'])
    ->name('celulares.destroy')
    ->middleware('auth');

//ventas
Route::get('ventas', [VentasController::class, 'index'])
    ->name('ventas')
    ->middleware('auth');

Route::get('ventas/create', [VentasController::class, 'create'])
    ->name('ventas.create')
    ->middleware('auth');

Route::get('ventas/{venta}/edit', [VentasController::class, 'edit'])
    ->name('ventas.edit')
    ->middleware('auth');

Route::put('ventas/{venta_id}', [VentasController::class, 'update'])
    ->name('ventas.update')
    ->middleware('auth');

Route::post('ventas', [VentasController::class, 'store'])
    ->name('ventas.store')
    ->middleware('auth');

Route::delete('ventas/{venta_id}', [VentasController::class, 'destroy'])
    ->name('ventas.destroy')
    ->middleware('auth');


// Gastos

Route::get('gastos', [GastosController::class, 'index'])
    ->name('gastos')
    ->middleware('auth');

Route::get('gastos/create', [GastosController::class, 'create'])
    ->name('gastos.create')
    ->middleware('auth');

Route::post('gastos', [GastosController::class, 'store'])
    ->name('gastos.store')
    ->middleware('auth');

Route::get('gastos/{gasto_id}/edit', [GastosController::class, 'edit'])
    ->name('gastos.edit')
    ->middleware('auth');

Route::put('gastos/{gasto_id}', [GastosController::class, 'update'])
    ->name('gastos.update')
    ->middleware('auth');

Route::delete('gastos/{gasto_id}', [GastosController::class, 'destroy'])
    ->name('gastos.destroy')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
