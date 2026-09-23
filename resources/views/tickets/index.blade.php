@extends('layouts.app')

@section('title', 'Painel de Chamados - Help Desk')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-grid-1x2-fill me-2"></i>
            Painel de Chamados
        </h1>

        <p class="text-muted mb-0">
            Gerencie os chamados do sistema de suporte.
        </p>
    </div>

    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Novo Chamado
    </a>
</div>


{{-- ESTATÍSTICAS --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Total de Chamados
                        </p>

                        <h2 class="mb-0">
                            {{ $stats['total'] ?? $tickets->total() }}
                        </h2>
                    </div>

                    <div class="fs-1 text-primary">
                        <i class="bi bi-ticket-detailed"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Em Atendimento
                        </p>

                        <h2 class="mb-0">
                            {{ $stats['in_progress'] ?? 0 }}
                        </h2>
                    </div>

                    <div class="fs-1 text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-muted mb-1">
                            Concluídos
                        </p>

                        <h2 class="mb-0">
                            {{ $stats['completed'] ?? 0 }}
                        </h2>
                    </div>

                    <div class="fs-1 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


{{-- FILTROS --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-funnel me-2"></i>
            Filtros
        </h5>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('tickets.index') }}">

            <div class="row g-3">

                {{-- BUSCA --}}
                <div class="col-md-5">

                    <label for="search" class="form-label">
                        Buscar
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Título ou solicitante..."
                        value="{{ request('search') }}"
                    >

                </div>


                {{-- DEPARTAMENTO --}}
                <div class="col-md-3">

                    <label for="department_id" class="form-label">
                        Departamento
                    </label>

                    <select
                        name="department_id"
                        id="department_id"
                        class="form-select"
                    >

                        <option value="">
                            Todos
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                {{ request('department_id') == $department->id ? 'selected' : '' }}
                            >
                                {{ $department->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="col-md-3">

                    <label for="status" class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos
                        </option>

                        <option
                            value="Aberto"
                            {{ request('status') === 'Aberto' ? 'selected' : '' }}
                        >
                            Aberto
                        </option>

                        <option
                            value="Em Atendimento"
                            {{ request('status') === 'Em Atendimento' ? 'selected' : '' }}
                        >
                            Em Atendimento
                        </option>

                        <option
                            value="Concluído"
                            {{ request('status') === 'Concluído' ? 'selected' : '' }}
                        >
                            Concluído
                        </option>

                    </select>

                </div>


                {{-- BOTÕES --}}
                <div class="col-md-1 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        title="Filtrar"
                    >
                        <i class="bi bi-search"></i>
                    </button>

                </div>

            </div>


            @if(request()->hasAny(['search', 'department_id', 'status']))

                <div class="mt-3">

                    <a
                        href="{{ route('tickets.index') }}"
                        class="btn btn-outline-secondary btn-sm"
                    >
                        <i class="bi bi-x-circle me-1"></i>
                        Limpar filtros
                    </a>

                </div>

            @endif

        </form>

    </div>

</div>


{{-- TABELA --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="bi bi-list-ul me-2"></i>
            Chamados
        </h5>

        <span class="badge bg-secondary">
            {{ $tickets->total() }} registros
        </span>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        <th>Chamado</th>

                        <th>Departamento</th>

                        <th>Solicitante</th>

                        <th>Prioridade</th>

                        <th>Status</th>

                        <th>Abertura</th>

                        <th class="text-end">
                            Ações
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($tickets as $ticket)

                        <tr>

                            {{-- ID --}}
                            <td>
                                <strong>
                                    #{{ $ticket->id }}
                                </strong>
                            </td>


                            {{-- TÍTULO --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $ticket->title }}
                                </div>

                                <small class="text-muted">
                                    {{ \Illuminate\Support\Str::limit($ticket->description, 60) }}
                                </small>

                            </td>


                            {{-- DEPARTAMENTO --}}
                            <td>

                                <span class="badge bg-light text-dark border">
                                    {{ $ticket->department->name ?? 'Sem departamento' }}
                                </span>

                            </td>


                            {{-- SOLICITANTE --}}
                            <td>
                                {{ $ticket->requester_name }}
                            </td>


                            {{-- PRIORIDADE --}}
                            <td>

                                @if($ticket->priority === 'Baixa')

                                    <span class="badge bg-success rounded-pill">
                                        Baixa
                                    </span>

                                @elseif($ticket->priority === 'Média')

                                    <span class="badge bg-info text-dark rounded-pill">
                                        Média
                                    </span>

                                @elseif($ticket->priority === 'Alta')

                                    <span class="badge bg-warning text-dark rounded-pill">
                                        Alta
                                    </span>

                                @elseif($ticket->priority === 'Urgente')

                                    <span class="badge bg-danger rounded-pill">
                                        Urgente
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @if($ticket->status === 'Aberto')

                                    <span class="badge bg-primary rounded-pill">
                                        Aberto
                                    </span>

                                @elseif($ticket->status === 'Em Atendimento')

                                    <span class="badge bg-warning text-dark rounded-pill">
                                        Em Atendimento
                                    </span>

                                @elseif($ticket->status === 'Concluído')

                                    <span class="badge bg-success rounded-pill">
                                        Concluído
                                    </span>

                                @endif

                            </td>


                            {{-- DATA --}}
                            <td>

                                {{ $ticket->created_at->format('d/m/Y H:i') }}

                            </td>


                            {{-- AÇÕES --}}
                            <td>

                                <div class="d-flex justify-content-end gap-2">

                                    <a
                                        href="{{ route('tickets.edit', $ticket->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Editar"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    <form
                                        action="{{ route('tickets.destroy', $ticket->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este chamado?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Excluir"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-inbox fs-1"></i>

                                    <h5 class="mt-3">
                                        Nenhum chamado encontrado
                                    </h5>

                                    <p class="mb-0">
                                        Ainda não existem chamados cadastrados.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- PAGINAÇÃO --}}
    @if($tickets->hasPages())

        <div class="card-footer bg-white">

            {{ $tickets->links() }}

        </div>

    @endif

</div>

@endsection