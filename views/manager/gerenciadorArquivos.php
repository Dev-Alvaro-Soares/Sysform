<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3MIL</title>
    <!-- Favicon -->
    <link rel="icon" href="../../public/img/faviconMPPA.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../public/css/estilos_gerenciador_registro.css">
    <link rel="stylesheet" href="../../public/vendor/bootstrap/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        /* Estilização customizada das abas */
        .nav-tabs .nav-link {
            color: #495057;
            border: 2px solid transparent;
            border-bottom: 2px solid #dee2e6;
            margin-top: 2rem;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
            color: #1e325c;
        }
        
        .nav-tabs .nav-link.active {
            color: #1e325c;
            font-weight: bold;
            background-color: #fff;
            border-color: #1e325c #1e325c #fff;
            border-bottom: 2px solid #fff;
        }
        
        /* Centralizar conteúdo das tabelas */
        .table thead th {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 0.75rem !important;
        }
        
        .table tbody td {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 0.75rem !important;
        }
        
        /* Adicionar margem inferior nas tabelas */
        .table {
            margin-bottom: 1rem;
            margin-top: 1rem;
        }
        
        /* Espaçamento entre header e abas */
        header + .container {
            margin-top: 1rem !important;
        }
        
        /* Estilização dos botões de ação */
        .btn-edit {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: white;
        }
        
        /* Espaçamento entre botões */
        table tbody td:last-child .btn {
            margin: 0 0.25rem;
        }
        
        /* Evitar quebra de linha na coluna de ações */
        table tbody td:last-child {
            white-space: nowrap;
            min-width: 230px;
        }
        
        /* Garantir que os botões não quebrem linha */
        table tbody td:last-child {
            display: table-cell;
        }

        /* Espaço extra abaixo da tabela de veículos */
        #veiculos {
            padding-bottom: 3rem;
        }
    </style>
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="header_container d-flex align-items-center justify-content-between">
            <h1 class="titulo-header">Gerenciador de registros</h1>
            <div class="d-flex align-items-center gap-4">
                <img class="logo-mppa" src="../../public/img/logoMppaBranco.png" alt="Logo do MPPA">
                <img class="logo-gsi" src="../../public/img/logoGsiMppa.png" alt="Logo do GSI">
            </div>
        </div>
    </header>
    
    <!-- Navegação por Abas -->
    <div class="container mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="veiculos-tab" data-bs-toggle="tab" href="#veiculos" role="tab" aria-controls="veiculos" aria-selected="true">
                    Solicitação Veículos
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="militares-tab" data-bs-toggle="tab" href="#militares" role="tab" aria-controls="militares" aria-selected="false">
                    Cadastro Militares
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="escolta-tab" data-bs-toggle="tab" href="#escolta" role="tab" aria-controls="escolta" aria-selected="false">
                    Solicitação Escolta
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Exemplo de Tabela para DataTables -->
    <main class="container mt-4">
        <!-- Conteúdo das Abas -->
        <div class="tab-content" id="myTabContent">
            <!-- Aba Solicitação Veículos -->
            <div class="tab-pane fade show active" id="veiculos" role="tabpanel" aria-labelledby="veiculos-tab">
                <h3 class="mb-3">Solicitação de Veículos</h3>
                <table id="tabelaVeiculos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nº do protocolo</th>
                            <th>Data do protocolo</th>
                            <th>Nome solicitante</th>
                            <th>Modelo do veículo</th>
                            <th>Data da missão</th>     
                            <th>Ações</th>     
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Seus dados aqui -->
                    </tbody>
                </table>
            </div>
            
            <!-- Aba Cadastro Militares -->
            <div class="tab-pane fade" id="militares" role="tabpanel" aria-labelledby="militares-tab">
                <h3 class="mb-3">Cadastro de Militares</h3>
                <table id="tabelaMilitares" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nº do protocolo</th>
                            <th>Data do protocolo</th>
                            <th>Nome Militar</th>
                            <th>Patente</th>
                            <th>Lotação</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Seus dados aqui -->
                    </tbody>
                </table>
            </div>
            
            <!-- Aba Solicitação Escolta -->
            <div class="tab-pane fade" id="escolta" role="tabpanel" aria-labelledby="escolta-tab">
                <h3 class="mb-3">Solicitação de Escolta</h3>
                <table id="tabelaEscolta" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nº de protocolo</th>
                            <th>Data do protocolo</th>
                            <th>Nome do protegido</th>
                            <th>Atividade realizada</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Seus dados aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <!-- jQuery (dependência do DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="../../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- Inicializar DataTables -->
    <script>
        $(document).ready(function() {
            // DataTables de veiculos, militares e escolta sera inicializado depois de carregar os dados
            // Ver gerenciador-veiculos.js, gerenciador-militares.js e gerenciador-escolta.js
        });
    </script>
    <!-- Script para gerenciar dados de veículos -->
    <script src="../../public/js/gerenciador-veiculos.js"></script>
    <!-- Script para gerenciar dados de militares -->
    <script src="../../public/js/gerenciador-militares.js"></script>
    <!-- Script para gerenciar dados de escolta -->
    <script src="../../public/js/gerenciador-escolta.js"></script>
</body>
</html>