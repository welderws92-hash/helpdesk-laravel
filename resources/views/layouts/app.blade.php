<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Help Desk')</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background-color: #f8f9fa;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar-wrapper {
            width: 250px;
            min-height: 100vh;
            background-color: #212529;
        }

        .sidebar-heading {
            padding: 20px;
            font-size: 1.3rem;
            font-weight: bold;
            background-color: #1a1d20;
        }

        #sidebar-wrapper .list-group-item {
            background-color: #212529;
            color: #adb5bd;
            border: none;
            padding: 15px 20px;
        }

        #sidebar-wrapper .list-group-item:hover {
            background-color: #343a40;
            color: #fff;
        }

        #sidebar-wrapper .list-group-item.active {
            background-color: #0d6efd;
            color: #fff;
        }

        #page-content-wrapper {
            flex: 1;
        }

        .top-navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 25px;
        }
    </style>
</head>

<body>

<div id="wrapper">

    <!-- MENU LATERAL -->
    <aside id="sidebar-wrapper">

        <div class="sidebar-heading text-primary">
            <i class="bi bi-headset me-2"></i>
            TechAssist
        </div>

        <div class="list-group list-group-flush mt-3">

            <a
                href="{{ route('tickets.index') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('tickets.index') ? 'active' : '' }}"
            >
                <i class="bi bi-grid-1x2-fill me-2"></i>
                Painel de Chamados
            </a>

            <a
                href="{{ route('tickets.create') }}"
                class="list-group-item list-group-item-action {{ request()->routeIs('tickets.create') ? 'active' : '' }}"
            >
                <i class="bi bi-plus-circle-fill me-2"></i>
                Abrir Novo Chamado
            </a>

        </div>

    </aside>

    <!-- CONTEÚDO -->
    <div id="page-content-wrapper">

        <!-- BARRA SUPERIOR -->
        <header class="top-navbar d-flex justify-content-between align-items-center">

            <div>
                <strong>Sistema de Suporte por Departamento</strong>
            </div>

            <div>
                <span class="badge bg-primary">
                    <i class="bi bi-person-fill me-1"></i>
                    Operador
                </span>
            </div>

        </header>

        <!-- CONTEÚDO DA PÁGINA -->
        <main class="container-fluid p-4">

            <!-- MENSAGEM DE SUCESSO -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Fechar"
                    ></button>
                </div>
            @endif

            <!-- MENSAGEM DE ERRO -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Fechar"
                    ></button>
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

</body>
</html>