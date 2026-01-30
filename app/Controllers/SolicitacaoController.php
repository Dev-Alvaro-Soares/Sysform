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

    $hasNumeroProtocolo = hasColumn($pdo, $dbSchema, 'registro_veiculos', 'numero_protocolo');
    $numero_protocolo = $hasNumeroProtocolo ? generateProtocol($pdo, $dbSchema, 'registro_veiculos', 'numero_protocolo') : null;

    $columns = "modelo, nome, matricula, data_missao, quilometragem_inicial, quilometragem_final, retirada, devolucao, observacao";
    $values = ":modelo, :nome, :matricula, :data_missao, :qi, :qf, :retirada, :devolucao, :observacao";
    if ($hasNumeroProtocolo) {
        $columns .= ", numero_protocolo";
        $values .= ", :numero_protocolo";
    }

    $sql = "INSERT INTO registro_veiculos ({$columns}) VALUES ({$values})";

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
    if ($hasNumeroProtocolo) {
        $stmt->bindValue(':numero_protocolo', $numero_protocolo, $numero_protocolo === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    }

    $stmt->execute();

    $pdo->commit();

    $protocolParam = $numero_protocolo ? ('&protocolo=' . urlencode($numero_protocolo)) : '';
    header('Location: ../../views/solicitacao_veiculos.php?success=1' . $protocolParam);
    exit;

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo '<h3>Erro ao conectar/inserir no banco:</h3>' . htmlspecialchars($e->getMessage());
    echo '<p><a href="../../views/solicitacao_veiculos.php">Voltar</a></p>';
    exit;
}
?>
