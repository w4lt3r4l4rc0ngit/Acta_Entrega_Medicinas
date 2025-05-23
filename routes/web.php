<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\NotaEntregaController::class, 'create'])->name('actaentrega.create');
Route::get('buscar_paciente', [App\Http\Controllers\NotaEntregaController::class, 'buscar_paciente'])->name('actaentrega.buscar_paciente');
Route::get('buscar_producto', [App\Http\Controllers\NotaEntregaController::class, 'buscar_producto'])->name('actaentrega.buscar_producto');
Route::post('/acta_entrega/guardar', [App\Http\Controllers\NotaEntregaController::class, 'guardar'])->name('acta_entrega.guardar');
Route::get('/acta/pdf/{id}', [App\Http\Controllers\NotaEntregaController::class, 'verPdf'])->name('acta.pdf');
