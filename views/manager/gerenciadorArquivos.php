<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3MIL</title>
    <!-- Favicon -->
    <link rel="icon" href="../../public/img/faviconMPPA.png" type="image/x-icon" />
    <link rel="stylesheet" href="../../public/css/estilos_gerenciador_registro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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
    
    <!-- Exemplo de Tabela para DataTables -->
    <main class="container mt-4">
        <table id="minhaTabela" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <!-- Seus dados aqui -->
            </tbody>
        </table>
    </main>
    
    <!-- jQuery (dependência do DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- Inicializar DataTables -->
    <script>
        $(document).ready(function() {
            $('#minhaTabela').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
                }
            });
        });
    </script>
</body>
</html>