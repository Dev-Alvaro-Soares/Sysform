<?php
/**
 * Controller para salvar solicitação de veículos via PDO
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/solicitacao_veiculos.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$matricula = trim($_POST['matricula'] ?? '');
$data_missao = trim($_POST['data_missao'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$quilometragem_inicial = isset($_POST['quilometragem_inicial']) ? intval($_POST['quilometragem_inicial']) : null;
$quilometragem_final = isset($_POST['quilometragem_final']) && $_POST['quilometragem_final'] !== '' ? intval($_POST['quilometragem_final']) : null;
$retirada = trim($_POST['retirada'] ?? null);
$devolucao = trim($_POST['devolucao'] ?? null);
$observacao = trim($_POST['observacao'] ?? null);

$errors = [];
if ($nome === '') {
    $errors[] = 'Nome é obrigatório.';
}
if (!is_int($quilometragem_inicial) || $quilometragem_inicial < 0) {
    $errors[] = 'Quilometragem inicial inválida.';
}

if (count($errors) > 0) {
    echo '<h3>Erros:</h3><ul>'; 
    foreach ($errors as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
    echo '</ul><p><a href="../../views/solicitacao_veiculos.php">Voltar</a></p>';
    exit;
}

$dbHost = '127.0.0.1';
$dbName = '3mil';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $sql = "INSERT INTO registro_veiculos (modelo, nome, matricula, data_missao, quilometragem_inicial, quilometragem_final, retirada, devolucao, observacao)
            VALUES (:modelo, :nome, :matricula, :data_missao, :qi, :qf, :retirada, :devolucao, :observacao)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':modelo', $modelo ?: null, PDO::PARAM_STR);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':matricula', $matricula ?: null, PDO::PARAM_STR);
    $stmt->bindValue(':data_missao', $data_missao ?: null, PDO::PARAM_STR);
    $stmt->bindValue(':qi', $quilometragem_inicial, PDO::PARAM_INT);
    if ($quilometragem_final === null) {
        $stmt->bindValue(':qf', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':qf', $quilometragem_final, PDO::PARAM_INT);
    }
    $stmt->bindValue(':retirada', $retirada ?: null, PDO::PARAM_STR);
    $stmt->bindValue(':devolucao', $devolucao ?: null, PDO::PARAM_STR);
    $stmt->bindValue(':observacao', $observacao ?: null, PDO::PARAM_STR);

    $stmt->execute();

    header('Location: ../../views/solicitacao_veiculos.php?success=1');
    exit;

} catch (PDOException $e) {
    echo '<h3>Erro ao conectar/inserir no banco:</h3>' . htmlspecialchars($e->getMessage());
    echo '<p><a href="../../views/solicitacao_veiculos.php">Voltar</a></p>';
    exit;
}
?>
