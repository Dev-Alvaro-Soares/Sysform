<?php
declare(strict_types=1);

$views = [
	'cadastro_militares' => __DIR__ . '/../views/forms/cadastro_militares.php',
	'solicitacao_escolta' => __DIR__ . '/../views/forms/solicitacao_escolta.php',
	'solicitacao_veiculos' => __DIR__ . '/../views/forms/solicitacao_veiculos.php',
];

$page = $_GET['page'] ?? 'home';

if ($page === 'home') {
	?>
	<!DOCTYPE html>
	<html lang="pt-BR">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Sysform</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
			  integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
			  crossorigin="anonymous">
	</head>
	<body class="bg-light">
		<main class="container py-5">
			<h1 class="mb-4">Sysform</h1>
			<div class="list-group">
				<a class="list-group-item list-group-item-action" href="index.php?page=cadastro_militares">Cadastro de militares</a>
				<a class="list-group-item list-group-item-action" href="index.php?page=solicitacao_escolta">Solicitação de escolta</a>
				<a class="list-group-item list-group-item-action" href="index.php?page=solicitacao_veiculos">Solicitação de veículos</a>
			</div>
		</main>
	</body>
	</html>
	<?php
	exit;
}

if (!isset($views[$page])) {
	http_response_code(404);
	echo 'Página não encontrada.';
	exit;
}

require $views[$page];
