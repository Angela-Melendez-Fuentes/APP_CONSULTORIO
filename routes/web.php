<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ConsultaController;

Route::post('/cita/{id}/consulta', [ConsultaController::class, 'store'])->name('cita.consulta');


Route::get('/medicamentos', [MedicamentoController::class, 'index'])->name('medicamentos.index');
Route::get('/cita/consulta', [MedicamentoController::class, 'mostrarFormulario'])->name('cita.consulta');
Route::get('/mostrar-formulario', [MedicamentoController::class, 'mostrarFormulario'])->name('mostrar.formulario');
Route::post('/medicamentos', [MedicamentoController::class, 'store'])->name('medicamentos.store');



Route::match(['get', 'post'], 'cita/consulta/{id}', [CitaController::class, 'consulta'])->name('cita.consulta');




Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/horas-ocupadas/{fecha}/{doctor_id}', [CitaController::class, 'horasOcupadas']);



Route::get('/admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('admin.register');
Route::get('/admin/administrar', [UsuarioController::class, 'index'])->name('admin.administrar');

Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.administrar');
Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');




Route::get('/pacientes/registrar_pacientes', [PacienteController::class, 'registrar_paciente'])->middleware(['auth', 'verified'])->name('registrar_paciente');
Route::post('/pacientes', [PacienteController::class, 'registro_paciente'])->middleware(['auth', 'verified'])->name('registro_paciente');
Route::get('/pacientes/{id}/edit', [PacienteController::class, 'edit'])->middleware(['auth', 'verified'])->name('paciente.edit');
Route::delete('pacientes/{id}', [PacienteController::class, 'destroy'])->name('paciente.destroy');
Route::resource('paciente', PacienteController::class);
Route::get('/pacientes', [PacienteController::class, 'paciente'])->middleware(['auth', 'verified'])->name('paciente');
Route::get('/paciente/{id}', [PacienteController::class, 'show'])->name('paciente.show');







Route::get('/doctor/servicios', [ServicioController::class, 'index'])->name('doctor.servicios');
Route::get('/servicios/create', [ServicioController::class, 'create'])->name('servicios.create');
Route::post('/doctor/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');




Route::get('/cita/agendar',[CitaController::class, 'agendar_cita'])->middleware(['auth', 'verified'])->name('agendar_cita');
Route::get('/cita/agandar', [CitaController::class, 'create'])->name('cita.agendar');
Route::get('cita/agendar', [CitaController::class, 'create'])->name('cita.agendar');

Route::post('/cita', [CitaController::class, 'store'])->name('cita.store');
Route::get('/citas/{id}', [CitaController::class, 'show'])->name('cita.show');
Route::get('/citas', [CitaController::class, 'index'])->name('cita.index');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';








































use App\Http\Controllers\MenuController;

Route::get('/', [MenuController::class, 'welcome'])->middleware(['auth', 'verified'])->name('welcome');
Route::get('/dashboard', [MenuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

