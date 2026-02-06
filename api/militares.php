<?php
/**
 * API para retornar dados de cadastro de militares em JSON
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Configuracao do banco de dados
    $dbHost = '192.168.123.32';
    $dbName = 'militar';
    $dbUser = 'militar';
    $dbPass = 'forms3Mil';
    $dbPort = 5432;
    $dbSchema = 'forms_militar';

    // Conexao com PostgreSQL
    $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Query para buscar os dados
    $sql = "SELECT
                numero_protocolo,
                created_at,
                nome_militar,
                patente,
                lotacao,
                telefone,
                email
            FROM {$dbSchema}.cadastro_militares
            WHERE numero_protocolo IS NOT NULL
            ORDER BY created_at DESC";

    $stmt = $pdo->query($sql);
    $registros = $stmt->fetchAll();

    // Formatar datas para exibicao
    foreach ($registros as &$registro) {
        $registro['created_at'] = date('d/m/Y', strtotime($registro['created_at']));
    }

    echo json_encode([
        'success' => true,
        'data' => $registros,
        'total' => count($registros)
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro ao conectar ao banco de dados',
        'message' => $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro inesperado',
        'message' => $e->getMessage()
    ]);
}
