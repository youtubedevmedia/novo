<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Controle Diário</title>
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
	<link rel="stylesheet" type="text/css" href="https://fernandogaspar.dev.br/controle-diario/css/style.css">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<link rel="manifest" href="https://fernandogaspar.dev.br/controle-diario/manifest.json">
</head>
<body>
	<?php if (isset($_SESSION['autenticado'])) { ?>
		<nav class="menu">
			<a href="https://fernandogaspar.dev.br/controle-diario/">INICIO</a>
			<a href="https://fernandogaspar.dev.br/controle-diario/registro/novo-registro.php">NOVO CUSTO</a>
			<a href="https://fernandogaspar.dev.br/controle-diario/configuracao.php">CONFIGURAÇÃO</a>
			<a href="https://fernandogaspar.dev.br/controle-diario/logout.php">SAIR</a>
		</nav>
	<?php } ?>
	<main class="main">