<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Exibe o painel de chamados.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('department');

        // Busca por título ou nome do solicitante
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('requester_name', 'like', "%{$search}%");
            });
        }

        // Filtro por departamento
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lista paginada
        $tickets = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Departamentos para o filtro
        $departments = Department::orderBy('name')->get();

        // Estatísticas
        $stats = [
            'total' => Ticket::count(),

            'in_progress' => Ticket::where(
                'status',
                'Em Atendimento'
            )->count(),

            'completed' => Ticket::where(
                'status',
                'Concluído'
            )->count(),
        ];

        return view('tickets.index', compact(
            'tickets',
            'departments',
            'stats'
        ));
    }


    /**
     * Exibe o formulário para criar um chamado.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('tickets.create', compact('departments'));
    }


    /**
     * Salva um novo chamado.
     */
    public function store(TicketRequest $request)
    {
        $data = $request->validated();

        // Se nenhum status for enviado, o chamado começa como Aberto.
        $data['status'] = $data['status'] ?? 'Aberto';

        Ticket::create($data);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado criado com sucesso!');
    }


    /**
     * Exibe o formulário de edição.
     */
    public function edit(Ticket $ticket)
    {
        $departments = Department::orderBy('name')->get();

        return view('tickets.edit', compact(
            'ticket',
            'departments'
        ));
    }


    /**
     * Atualiza um chamado existente.
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado atualizado com sucesso!');
    }


    /**
     * Altera somente o status do chamado.
     */
    public function status(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:Aberto,Em Atendimento,Concluído',
        ]);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Status atualizado com sucesso!');
    }


    /**
     * Exclui um chamado.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado excluído com sucesso!');
    }
}