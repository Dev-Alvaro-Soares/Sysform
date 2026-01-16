<?php
/**
 * Controller para salvar solicitação de escolta via PDO
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['Método não permitido']]);
    exit;
}

$nome_protegido = trim($_POST['nome_protegido'] ?? '');
$atividade_missao = trim($_POST['atividade_missao'] ?? '');
$localidades = trim($_POST['localidades'] ?? '');
$data_inicio_missao = trim($_POST['data_inicio_missao'] ?? '');
$data_final_missao = trim($_POST['data_final_missao'] ?? '');
$horario_chegada = trim($_POST['horario_chegada'] ?? '');
$horario_saida = trim($_POST['horario_saida'] ?? '');
$descricao_atividades = trim($_POST['descricao_atividades'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? null);

$errors = [];
if ($nome_protegido === '') {
    $errors[] = 'Nome do protegido é obrigatório.';
}
if ($atividade_missao === '') {
    $errors[] = 'Atividade da missão é obrigatória.';
}
if ($localidades === '') {
    $errors[] = 'Localidade é obrigatória.';
}
if ($data_inicio_missao === '') {
    $errors[] = 'Data do início da missão é obrigatória.';
}
if ($data_final_missao === '') {
    $errors[] = 'Data do final da missão é obrigatória.';
}
if ($horario_chegada === '') {
    $errors[] = 'Horário de chegada é obrigatório.';
}
if ($horario_saida === '') {
    $errors[] = 'Horário de saída é obrigatório.';
}
if ($descricao_atividades === '') {
    $errors[] = 'Descrição das atividades é obrigatória.';
}

if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
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

    $sql = "INSERT INTO registro_escolta (nome_protegido, atividade_missao, localidades, data_inicio_missao, data_final_missao, horario_chegada, horario_saida, descricao_atividades, observacoes)
            VALUES (:nome_protegido, :atividade_missao, :localidades, :data_inicio_missao, :data_final_missao, :horario_chegada, :horario_saida, :descricao_atividades, :observacoes)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nome_protegido', $nome_protegido, PDO::PARAM_STR);
    $stmt->bindValue(':atividade_missao', $atividade_missao, PDO::PARAM_STR);
    $stmt->bindValue(':localidades', $localidades, PDO::PARAM_STR);
    $stmt->bindValue(':data_inicio_missao', $data_inicio_missao, PDO::PARAM_STR);
    $stmt->bindValue(':data_final_missao', $data_final_missao, PDO::PARAM_STR);
    $stmt->bindValue(':horario_chegada', $horario_chegada, PDO::PARAM_STR);
    $stmt->bindValue(':horario_saida', $horario_saida, PDO::PARAM_STR);
    $stmt->bindValue(':descricao_atividades', $descricao_atividades, PDO::PARAM_STR);
    $stmt->bindValue(':observacoes', $observacoes ?: null, PDO::PARAM_STR);

    $stmt->execute();

    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Solicitação enviada com sucesso.']);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => ['Erro ao conectar/inserir no banco: ' . $e->getMessage()]]);
    exit;
}
?>
?>
