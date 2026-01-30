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
$equipe_militar_json = $_POST['equipe_militar_json'] ?? '[]';

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

// Validar JSON da equipe
$equipe_militar = json_decode($equipe_militar_json, true);
if ($equipe_militar_json !== '[]' && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => ['Formato de equipe militar inválido.']]);
    exit;
}

$dbHost = '192.168.123.32';
$dbName = 'militar';
$dbUser = 'militar';
$dbPass = 'forms3Mil';
$dbPort = 5432;
$dbSchema = 'forms_militar';

function hasColumn(PDO $pdo, string $schema, string $table, string $column): bool
{
    $sql = "SELECT 1 FROM information_schema.columns WHERE table_schema = :schema AND table_name = :table AND column_name = :column";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':schema' => $schema,
        ':table' => $table,
        ':column' => $column,
    ]);
    return (bool) $stmt->fetchColumn();
}

function generateProtocol(PDO $pdo, string $schema, string $table, string $column): string
{
    $year = date('Y');
    $lockKey = sprintf('%u', crc32("{$schema}.{$table}.{$column}.{$year}"));
    $pdo->prepare('SELECT pg_advisory_xact_lock(:lock_key)')->execute([':lock_key' => $lockKey]);

    $sql = "SELECT MAX({$column}) AS max_protocolo
            FROM {$schema}.{$table}
            WHERE {$column} LIKE :prefix";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':prefix' => $year . '%']);
    $max = $stmt->fetchColumn();

    $lastSeq = 0;
    if (is_string($max) && strlen($max) === 10) {
        $lastSeq = (int) substr($max, 4, 6);
    }

    $nextSeq = $lastSeq + 1;
    return $year . str_pad((string) $nextSeq, 6, '0', STR_PAD_LEFT);
}

try {
    $pdo = new PDO("pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Definir schema
    $pdo->exec("SET search_path TO {$dbSchema}");

    $pdo->beginTransaction();

    $hasNumeroProtocolo = hasColumn($pdo, $dbSchema, 'registro_escolta', 'numero_protocolo');
    $numero_protocolo = $hasNumeroProtocolo ? generateProtocol($pdo, $dbSchema, 'registro_escolta', 'numero_protocolo') : null;

    $columns = "nome_protegido, atividade_missao, localidades, data_inicio_missao, data_final_missao, horario_chegada, horario_saida, descricao_atividades, observacoes";
    $values = ":nome_protegido, :atividade_missao, :localidades, :data_inicio_missao, :data_final_missao, :horario_chegada, :horario_saida, :descricao_atividades, :observacoes";
    if ($hasNumeroProtocolo) {
        $columns .= ", numero_protocolo";
        $values .= ", :numero_protocolo";
    }

    $sql = "INSERT INTO registro_escolta ({$columns}) VALUES ({$values})";

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
    if ($hasNumeroProtocolo) {
        $stmt->bindValue(':numero_protocolo', $numero_protocolo, $numero_protocolo === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    }

    $stmt->execute();

    $registroId = $pdo->lastInsertId();

    if (is_array($equipe_militar) && count($equipe_militar) > 0) {
        $sqlEquipe = "INSERT INTO equipe_militar (patente, nome, funcao, id_registro_escolta)
                      VALUES (:patente, :nome, :funcao, :id_registro_escolta)";
        $stmtEquipe = $pdo->prepare($sqlEquipe);

        foreach ($equipe_militar as $membro) {
            $patente = trim($membro['patente'] ?? '');
            $nome = trim($membro['nome'] ?? '');
            $funcao = trim($membro['funcao'] ?? '');

            if ($patente === '' || $nome === '' || $funcao === '') {
                continue; // ignora itens inválidos
            }

            $stmtEquipe->bindValue(':patente', $patente, PDO::PARAM_STR);
            $stmtEquipe->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmtEquipe->bindValue(':funcao', $funcao, PDO::PARAM_STR);
            $stmtEquipe->bindValue(':id_registro_escolta', $registroId, PDO::PARAM_INT);
            $stmtEquipe->execute();
        }
    }

    $pdo->commit();

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Solicitação enviada com sucesso.',
        'numero_protocolo' => $numero_protocolo,
    ]);
    exit;

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => ['Erro ao conectar/inserir no banco: ' . $e->getMessage()]]);
    exit;
}
?>
