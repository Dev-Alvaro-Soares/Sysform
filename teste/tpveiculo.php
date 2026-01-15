<?php
// Configurações de conexão
$servername = "localhost";
$username = "root";  // usuário padrão do XAMPP
$password = "";      // senha padrão (geralmente vazia)
$dbname = "solicitacoes";    // nome do banco criado

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Definir charset UTF-8
$conn->set_charset("utf8mb4");

// Validar se dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./formulario_tipo_veiculo.html");
    exit;
}

// Validar e sanitizar entradas
$descricao = isset($_POST['nomeveiculo']) ? trim($_POST['nomeveiculo']) : '';
$placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : '';

// Validações básicas
$erros = [];

if (empty($descricao) || strlen($descricao) < 3) {
    $erros[] = "Tipo do veículo deve ter no mínimo 3 caracteres.";
}

if (!preg_match('/^[A-Z]{3}-?[0-9]{4}$/', $placa)) {
    $erros[] = "Placa inválida. Use o formato: ABC-1234";
}

// Se houver erros, exibir mensagens
if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erro no Cadastro</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='p-5'>
        <div class='alert alert-danger' role='alert'>
            <h4 class='alert-heading'>❌ Erro ao cadastrar!</h4>";
    foreach ($erros as $erro) {
        echo "<p>" . htmlspecialchars($erro) . "</p>";
    }
    echo "    </div>
        <a href='./formulario_tipo_veiculo.html' class='btn btn-primary'>Voltar ao formulário</a>
    </body>
    </html>";
    $conn->close();
    exit;
}

// Normalizar placa (remover traço se existir)
$placa = str_replace('-', '', $placa);

// Verificar se placa já existe (duplicata)
$stmt_check = $conn->prepare("SELECT id FROM tipo_veiculo WHERE placa = ?");
if (!$stmt_check) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt_check->bind_param("s", $placa);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo "<!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Placa Duplicada</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='p-5'>
        <div class='alert alert-warning' role='alert'>
            <h4 class='alert-heading'>⚠️ Aviso</h4>
            <p>A placa <strong>" . htmlspecialchars($placa) . "</strong> já está cadastrada no sistema.</p>
        </div>
        <a href='./formulario_tipo_veiculo.html' class='btn btn-primary'>Voltar ao formulário</a>
    </body>
    </html>";
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// Preparar e executar o INSERT
$sql = "INSERT INTO tipo_veiculo(descricao, placa) VALUES (?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param("ss", $descricao, $placa);

if ($stmt->execute()) {
    echo "<!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Sucesso!</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='p-5'>
        <div class='alert alert-success' role='alert'>
            <h4 class='alert-heading'>✅ Cadastro realizado com sucesso!</h4>
            <hr>
            <p><strong>Tipo:</strong> " . htmlspecialchars($descricao) . "</p>
            <p><strong>Placa:</strong> " . htmlspecialchars($placa) . "</p>
        </div>
        <a href='./formulario_tipo_veiculo.html' class='btn btn-primary'>Voltar ao formulário</a>
    </body>
    </html>";
} else {
    echo "<!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erro no Banco</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='p-5'>
        <div class='alert alert-danger' role='alert'>
            <h4 class='alert-heading'>❌ Erro ao inserir no banco de dados</h4>
            <p>" . htmlspecialchars($stmt->error) . "</p>
        </div>
        <a href='./formulario_tipo_veiculo.html' class='btn btn-primary'>Voltar ao formulário</a>
    </body>
    </html>";
}

// Fechar conexão
$stmt->close();
$conn->close();
?>
