<?php
use App\Models\Tecnologa; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;
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
    $tecnologas = Tecnologa::orderBy('NombreCompleto')->get();  // Obtén todas las tecnologías
    return view('welcome', compact('tecnologas'));  // Pásalas a la vista
});

Route::get('/pacientes/exportar', [PacientesController::class, 'exportar'])->name('pacientes.exportar');
Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
//Route::get('/welcome', [PacientesController::class, 'index'])->name('pacientes.index');
Route::get('/pacientes/buscar', [PacientesController::class, 'buscar']);
Route::get('/pacientes/{filtro?}', [PacientesController::class, 'pacientes']);
Route::get('/pacientes/{n_orden}/editar', [PacientesController::class, 'edit'])->name('pacientes.edit');
Route::post('/pacientes/{n_orden}/actualizar', [PacientesController::class, 'update'])->name('pacientes.update');




