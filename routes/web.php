<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


// Painel principal
Route::get('/', [TicketController::class, 'index'])
    ->name('tickets.index');

Route::get('/tickets', [TicketController::class, 'index'])
    ->name('tickets.index');

// Formulário para abrir chamado
Route::get('/tickets/create', [TicketController::class, 'create'])
    ->name('tickets.create');

// Criar chamado
Route::post('/tickets', [TicketController::class, 'store'])
    ->name('tickets.store');

// Formulário para editar chamado
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])
    ->name('tickets.edit');

// Atualizar chamado
Route::put('/tickets/{ticket}', [TicketController::class, 'update'])
    ->name('tickets.update');

// Alterar somente o status
Route::patch('/tickets/{ticket}/status', [TicketController::class, 'status'])
    ->name('tickets.status');

// Excluir chamado
Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])
    ->name('tickets.destroy');