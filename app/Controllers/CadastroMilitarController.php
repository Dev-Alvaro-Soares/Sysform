<?php
/**
 * Processamento seguro do formulário de cadastro de militares
 * - Valida extensão .pdf
 * - Valida MIME type
 * - Gera nomes únicos para arquivos
 * - Previne ataques (path traversal, BLOBs grandes)
 */

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/cadastro_militares.php');
    exit;
}

// Configurações
define('UPLOAD_DIR', __DIR__ . '/../../media/');
define('MAX_FILE_SIZE', 20 * 1024 * 1024); // 20MB máximo
define('ALLOWED_EXTENSIONS', ['pdf']);
define('ALLOWED_MIME_TYPES', ['application/pdf', 'application/x-pdf']);
define('PDF_MAGIC_BYTES', '%PDF'); // Assinatura de arquivo PDF

// Criar diretório de upload se não existir
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

// Configurações do banco de dados
$dbHost = '192.168.123.32';
$dbName = 'militar';
$dbUser = 'militar';
$dbPass = 'forms3Mil';
$dbPort = 5432;
$dbSchema = 'forms_militar';

/**
 * Valida se um arquivo é realmente um PDF verificando:
 * 1. Extensão
 * 2. MIME type
 * 3. Magic bytes (assinatura de arquivo)
 * 4. Tamanho
 */
function validatePdfFile($filePath, $fileName, $fileSize)
{
    // 1. Validar tamanho
    if ($fileSize > MAX_FILE_SIZE) {
        throw new Exception("Arquivo $fileName excede o tamanho máximo permitido (20MB)");
    }

    if ($fileSize < 100) {
        throw new Exception("Arquivo $fileName é muito pequeno para ser um PDF válido");
    }

    // 2. Validar extensão
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExt, ALLOWED_EXTENSIONS)) {
        throw new Exception("Apenas arquivos PDF são permitidos. Recebido: .$fileExt");
    }

    // 3. Validar MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $filePath);
    finfo_close($finfo);

    if (!in_array($mimeType, ALLOWED_MIME_TYPES)) {
        throw new Exception("Arquivo $fileName não é um PDF válido. MIME detectado: $mimeType");
    }

    // 4. Validar magic bytes (assinatura PDF)
    $handle = fopen($filePath, 'rb');
    $magicBytes = fread($handle, 4);
    fclose($handle);

    if ($magicBytes !== PDF_MAGIC_BYTES) {
        throw new Exception("Arquivo $fileName não possui assinatura PDF válida. Arquivo rejeitado por segurança.");
    }

    return true;
}

/**
 * Salva um arquivo PDF de forma segura
 */
function saveUploadedFile($fileInputName, $purpose = 'documento')
{
    if (!isset($_FILES[$fileInputName])) {
        return null; // Campo não foi enviado
    }

    $file = $_FILES[$fileInputName];

    // Validar erros de upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE => 'Arquivo excede php.ini upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'Arquivo excede form MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'Upload do arquivo foi interrompido',
            UPLOAD_ERR_NO_FILE => 'Nenhum arquivo foi enviado',
            UPLOAD_ERR_NO_TMP_DIR => 'Pasta temporária não existe',
            UPLOAD_ERR_CANT_WRITE => 'Erro ao escrever arquivo no disco',
            UPLOAD_ERR_EXTENSION => 'Upload bloqueado por extensão PHP'
        ];
        $errorMsg = $uploadErrors[$file['error']] ?? 'Erro desconhecido no upload';
        throw new Exception("Erro no upload: $errorMsg");
    }

    $fileName = basename($file['name']); // Remove path
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];

    // Validar PDF
    validatePdfFile($fileTmpPath, $fileName, $fileSize);

    // Gerar nome único e seguro
    $timestamp = date('YmdHis');
    $randomStr = bin2hex(random_bytes(8));
    $safeFileName = "{$purpose}_{$timestamp}_{$randomStr}.pdf";
    $uploadPath = UPLOAD_DIR . $safeFileName;

    // Garantir que o arquivo não sobrescreve outro
    while (file_exists($uploadPath)) {
        $randomStr = bin2hex(random_bytes(8));
        $safeFileName = "{$purpose}_{$timestamp}_{$randomStr}.pdf";
        $uploadPath = UPLOAD_DIR . $safeFileName;
    }

    // Salvar arquivo
    if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
        throw new Exception("Erro ao salvar arquivo $fileName no servidor");
    }

    // Definir permissões restritivas (leitura apenas)
    chmod($uploadPath, 0644);

    // Retornar caminho relativo para armazenar no banco
    return "media/{$safeFileName}";
}

// Processar dados do formulário
try {
    // Conectar ao banco de dados
    $pdo = new PDO("pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Definir schema
    $pdo->exec("SET search_path TO {$dbSchema}");

    // Processar uploads de documentos (se enviados)
    $docMilitarArquivo = null;
    $docCivilArquivo = null;

    if (!empty($_FILES)) {
        if (isset($_FILES['doc_militar']) && $_FILES['doc_militar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $docMilitarArquivo = saveUploadedFile('doc_militar', 'doc_militar');
        }
        if (isset($_FILES['doc_civil']) && $_FILES['doc_civil']['error'] !== UPLOAD_ERR_NO_FILE) {
            $docCivilArquivo = saveUploadedFile('doc_civil', 'doc_civil');
        }
    }

    // Preparar dados para inserção
    $stmt = $pdo->prepare("
        INSERT INTO cadastro_militares (
            nome_militar, nome_guerra, patente, lotacao,
            doc_militar_numero, doc_militar_arquivo,
            nome_civil, nome_mae,
            doc_civil_numero, doc_civil_arquivo,
            endereco_pessoal, bairro_pessoal, cidade_pessoal, estado_pessoal, cep_pessoal,
            endereco_funcional, bairro_funcional, cidade_funcional, estado_funcional, cep_funcional,
            qualificacao, indicado_por, telefone, email,
            conjuge, numero_filhos, tipo_sanguineo, vinculo_mp,
            created_at
        ) VALUES (
            :nome_militar, :nome_guerra, :patente, :lotacao,
            :doc_militar_numero, :doc_militar_arquivo,
            :nome_civil, :nome_mae,
            :doc_civil_numero, :doc_civil_arquivo,
            :endereco_pessoal, :bairro_pessoal, :cidade_pessoal, :estado_pessoal, :cep_pessoal,
            :endereco_funcional, :bairro_funcional, :cidade_funcional, :estado_funcional, :cep_funcional,
            :qualificacao, :indicado_por, :telefone, :email,
            :conjuge, :numero_filhos, :tipo_sanguineo, :vinculo_mp,
            NOW()
        )
    ");

    // Bind values com sanitização
    $stmt->execute([
        ':nome_militar' => trim($_POST['nome_militar'] ?? ''),
        ':nome_guerra' => trim($_POST['nome_guerra'] ?? ''),
        ':patente' => trim($_POST['patente'] ?? ''),
        ':lotacao' => trim($_POST['lotacao'] ?? ''),
        ':doc_militar_numero' => trim($_POST['doc_militar_numero'] ?? ''),
        ':doc_militar_arquivo' => $docMilitarArquivo,
        ':nome_civil' => trim($_POST['nome_civil'] ?? ''),
        ':nome_mae' => trim($_POST['nome_mae'] ?? ''),
        ':doc_civil_numero' => trim($_POST['doc_civil_numero'] ?? ''),
        ':doc_civil_arquivo' => $docCivilArquivo,
        ':endereco_pessoal' => trim($_POST['endereco_pessoal'] ?? ''),
        ':bairro_pessoal' => trim($_POST['bairro_pessoal'] ?? ''),
        ':cidade_pessoal' => trim($_POST['cidade_pessoal'] ?? ''),
        ':estado_pessoal' => trim($_POST['estado_pessoal'] ?? ''),
        ':cep_pessoal' => trim($_POST['cep_pessoal'] ?? ''),
        ':endereco_funcional' => trim($_POST['endereco_funcional'] ?? ''),
        ':bairro_funcional' => trim($_POST['bairro_funcional'] ?? ''),
        ':cidade_funcional' => trim($_POST['cidade_funcional'] ?? ''),
        ':estado_funcional' => trim($_POST['estado_funcional'] ?? ''),
        ':cep_funcional' => trim($_POST['cep_funcional'] ?? ''),
        ':qualificacao' => trim($_POST['qualificacao'] ?? ''),
        ':indicado_por' => trim($_POST['indicado_por'] ?? ''),
        ':telefone' => trim($_POST['telefone'] ?? ''),
        ':email' => filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL),
        ':conjuge' => trim($_POST['conjuge'] ?? ''),
        ':numero_filhos' => !empty($_POST['numero_filhos']) ? (int)$_POST['numero_filhos'] : null,
        ':tipo_sanguineo' => trim($_POST['tipo_sanguineo'] ?? ''),
        ':vinculo_mp' => trim($_POST['vinculo_mp'] ?? ''),
    ]);

    $insertId = $pdo->lastInsertId();

    // Processar e salvar cursos se houver
    $cursos = [];
    
    if (!empty($_POST['cursos_json'])) {
        // Cursos enviados como JSON (via AJAX)
        $cursosJson = json_decode($_POST['cursos_json'], true);
        if (is_array($cursosJson)) {
            $cursos = $cursosJson;
        }
    } elseif (!empty($_POST['cursos']) && is_array($_POST['cursos'])) {
        // Cursos enviados como array tradicional (fallback)
        $cursos = $_POST['cursos'];
    }

    if (!empty($cursos)) {
        $stmtCurso = $pdo->prepare("
            INSERT INTO cursos_militares (
                nome_curso, descricao, carga_horaria, data, 
                upload_arquivo, id_cadastro_militar
            ) VALUES (
                :nome_curso, :descricao, :carga_horaria, :data,
                :upload_arquivo, :id_cadastro_militar
            )
        ");

        foreach ($cursos as $cursoIndex => $curso) {
            // Processar arquivo do curso se fornecido
            $cursoPdfArquivo = null;
            
            // Verificar se há arquivo para este curso específico
            $fileKey = 'cursos_arquivo_' . $cursoIndex;
            if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] !== UPLOAD_ERR_NO_FILE) {
                try {
                    $fileArray = $_FILES[$fileKey];
                    
                    if ($fileArray['error'] === UPLOAD_ERR_OK) {
                        // Validar e salvar arquivo
                        validatePdfFile($fileArray['tmp_name'], $fileArray['name'], $fileArray['size']);
                        
                        $timestamp = date('YmdHis');
                        $randomStr = bin2hex(random_bytes(8));
                        $safeFileName = "curso_{$timestamp}_{$randomStr}.pdf";
                        $uploadPath = UPLOAD_DIR . $safeFileName;
                        
                        while (file_exists($uploadPath)) {
                            $randomStr = bin2hex(random_bytes(8));
                            $safeFileName = "curso_{$timestamp}_{$randomStr}.pdf";
                            $uploadPath = UPLOAD_DIR . $safeFileName;
                        }
                        
                        if (move_uploaded_file($fileArray['tmp_name'], $uploadPath)) {
                            chmod($uploadPath, 0644);
                            $cursoPdfArquivo = "media/{$safeFileName}";
                        }
                    }
                } catch (Exception $e) {
                    // Log erro mas continua o processo
                    error_log("Erro ao processar arquivo do curso: " . $e->getMessage());
                }
            }

            // Inserir curso no banco
            $stmtCurso->execute([
                ':nome_curso' => trim($curso['nome_curso'] ?? ''),
                ':descricao' => trim($curso['descricao'] ?? ''),
                ':carga_horaria' => !empty($curso['carga_horaria']) ? (int)$curso['carga_horaria'] : null,
                ':data' => $curso['data'] ?? null,
                ':upload_arquivo' => $cursoPdfArquivo,
                ':id_cadastro_militar' => $insertId
            ]);
        }
    }

    // Redirecionar com sucesso
    header('Location: ../../views/cadastro_militares.php?success=1');
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo '<h3>Erro ao conectar/inserir no banco:</h3>' . htmlspecialchars($e->getMessage());
    echo '<p><a href="../../views/cadastro_militares.php">Voltar</a></p>';
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo '<h3>Erro no processamento:</h3>' . htmlspecialchars($e->getMessage());
    echo '<p><a href="../../views/cadastro_militares.php">Voltar</a></p>';
    exit;
}
?>
