@extends('layouts.app')

@section('title', 'Editar Chamado #' . $ticket->id)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Chamado #{{ $ticket->id }}
        </h1>

        <p class="text-muted mb-0">
            Atualize as informações do chamado.
        </p>
    </div>

    <a
        href="{{ route('tickets.index') }}"
        class="btn btn-outline-secondary"
    >
        <i class="bi bi-arrow-left me-2"></i>
        Voltar
    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            <i class="bi bi-ticket-detailed me-2"></i>
            Dados do Chamado
        </h5>

    </div>


    <div class="card-body">

        <form
            action="{{ route('tickets.update', $ticket->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="row g-3">


                {{-- TÍTULO --}}
                <div class="col-md-8">

                    <label for="title" class="form-label">
                        Título <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $ticket->title) }}"
                        required
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- DEPARTAMENTO --}}
                <div class="col-md-4">

                    <label for="department_id" class="form-label">
                        Departamento <span class="text-danger">*</span>
                    </label>

                    <select
                        name="department_id"
                        id="department_id"
                        class="form-select @error('department_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Selecione um departamento
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                {{ old('department_id', $ticket->department_id) == $department->id ? 'selected' : '' }}
                            >
                                {{ $department->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('department_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- STATUS --}}
                <div class="col-md-4">

                    <label for="status" class="form-label">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >

                        <option
                            value="Aberto"
                            {{ old('status', $ticket->status) === 'Aberto' ? 'selected' : '' }}
                        >
                            Aberto
                        </option>

                        <option
                            value="Em Atendimento"
                            {{ old('status', $ticket->status) === 'Em Atendimento' ? 'selected' : '' }}
                        >
                            Em Atendimento
                        </option>

                        <option
                            value="Concluído"
                            {{ old('status', $ticket->status) === 'Concluído' ? 'selected' : '' }}
                        >
                            Concluído
                        </option>

                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- SOLICITANTE --}}
                <div class="col-md-4">

                    <label for="requester_name" class="form-label">
                        Nome do Solicitante <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="requester_name"
                        id="requester_name"
                        class="form-control @error('requester_name') is-invalid @enderror"
                        value="{{ old('requester_name', $ticket->requester_name) }}"
                        required
                    >

                    @error('requester_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- PRIORIDADE --}}
                <div class="col-md-4">

                    <label for="priority" class="form-label">
                        Prioridade <span class="text-danger">*</span>
                    </label>

                    <select
                        name="priority"
                        id="priority"
                        class="form-select @error('priority') is-invalid @enderror"
                        required
                    >

                        <option
                            value="Baixa"
                            {{ old('priority', $ticket->priority) === 'Baixa' ? 'selected' : '' }}
                        >
                            Baixa
                        </option>

                        <option
                            value="Média"
                            {{ old('priority', $ticket->priority) === 'Média' ? 'selected' : '' }}
                        >
                            Média
                        </option>

                        <option
                            value="Alta"
                            {{ old('priority', $ticket->priority) === 'Alta' ? 'selected' : '' }}
                        >
                            Alta
                        </option>

                        <option
                            value="Urgente"
                            {{ old('priority', $ticket->priority) === 'Urgente' ? 'selected' : '' }}
                        >
                            Urgente
                        </option>

                    </select>

                    @error('priority')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- DESCRIÇÃO --}}
                <div class="col-12">

                    <label for="description" class="form-label">
                        Descrição <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="6"
                        class="form-control @error('description') is-invalid @enderror"
                        required
                    >{{ old('description', $ticket->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- BOTÕES --}}
            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route('tickets.index') }}"
                    class="btn btn-outline-secondary px-4"
                >
                    <i class="bi bi-x-circle me-2"></i>
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary px-4"
                >
                    <i class="bi bi-check-circle me-2"></i>
                    Salvar Alterações
                </button>

            </div>

        </form>

    </div>

</div>

@endsection