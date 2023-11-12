<?php

use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/veiculos', function () {
    return view('veiculos');
})->middleware(['auth', 'verified'])->name('veiculos');

Route::get('/modelos', function () {
    return view('modelos');
})->middleware(['auth', 'verified'])->name('modelos');

Route::get('/marcas', function () {
    return view('marcas');
})->middleware(['auth', 'verified'])->name('marcas');

Route::get('/veiculos/listar', [VeiculoController::class, 'listar'])->name('veiculos.listar');
Route::post('/veiculos/create', [VeiculoController::class, 'create'])->name('veiculo.create');
Route::put('/veiculos/{id}/update', [VeiculoController::class, 'update'])->name('veiculo.update');
Route::delete('/veiculos/{id}/delete', [VeiculoController::class, 'delete'])->name('veiculo.delete');



Route::get('/modelos/listar', [ModeloController::class, 'listar'])->name('modelos.listar');
Route::get('/modelos/create', [ModeloController::class, 'create'])->name('veiculo.create');
Route::put('/modelos/{id}/update', [ModeloController::class, 'update'])->name('veiculo.update');
Route::delete('/modelos/{id}/delete', [ModeloController::class, 'delete'])->name('veiculo.delete');
Route::get('/modelos/{id}', [ModeloController::class, 'getModelById'])->name('modelos.getModelById');






Route::get('/marcas/listar', [MarcaController::class, 'listar'])->name('marcas.listar');
Route::get('/marcas/create', [MarcaController::class, 'create'])->name('marcas.create');
Route::get('/marcas/get/{id}', [MarcaController::class, 'getMarcaByModelo'])->name('marcas.getMarcaByModelo');
Route::put('/marcas/{id}/update', [MarcaController::class, 'update'])->name('marcas.update');
Route::delete('/marcas/{id}/delete', [MarcaController::class, 'delete'])->name('marcas.delete');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
